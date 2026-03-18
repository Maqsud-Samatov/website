<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Food;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['food', 'restaurant'])
            ->get();

        $total    = $cartItems->sum(fn($item) => ($item->food->discount_price ?? $item->food->price) * $item->quantity);
        $delivery = $cartItems->first()?->restaurant?->delivery_fee ?? 0;

        return view('user.cart', compact('cartItems', 'total', 'delivery'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'food_id'  => 'required|exists:foods,id',
            'quantity' => 'integer|min:1|max:20',
        ]);

        $food = Food::findOrFail($request->food_id);

        // Check if different restaurant
        $existing = Cart::where('user_id', auth()->id())->first();
        if ($existing && $existing->restaurant_id != $food->restaurant_id) {
            return response()->json([
                'success' => false,
                'message' => 'Savatda boshqa restoran taomi bor. Avval savatni tozalang.',
            ], 422);
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('food_id', $food->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity ?? 1);
        } else {
            Cart::create([
                'user_id'       => auth()->id(),
                'food_id'       => $food->id,
                'restaurant_id' => $food->restaurant_id,
                'quantity'      => $request->quantity ?? 1,
            ]);
        }

        $count = Cart::where('user_id', auth()->id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Savatga qo\'shildi!',
            'count'   => $count,
        ]);
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);

        if ($request->quantity <= 0) {
            $cart->delete();
        } else {
            $cart->update(['quantity' => $request->quantity]);
        }

        return response()->json(['success' => true]);
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);
        $cart->delete();
        return back()->with('success', 'Savatdan o\'chirildi!');
    }

    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();
        return back()->with('success', 'Savat tozalandi!');
    }

    public function count()
    {
        $count = Cart::where('user_id', auth()->id())->sum('quantity');
        return response()->json(['count' => $count]);
    }
}