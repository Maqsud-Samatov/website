<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\ClickService;
use App\Services\PaymeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    const COMMISSION = 0.10;

    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['food', 'restaurant'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Savat bo\'sh!');
        }

        $subtotal   = $cartItems->sum(fn($i) => ($i->food->discount_price ?? $i->food->price) * $i->quantity);
        $delivery   = $cartItems->first()?->restaurant?->delivery_fee ?? 0;
        $total      = $subtotal + $delivery;
        $commission = round($total * self::COMMISSION);
        $restaurant = $cartItems->first()?->restaurant;
        $user       = auth()->user();

        return view('user.checkout', compact(
            'cartItems', 'subtotal', 'delivery',
            'total', 'commission', 'restaurant', 'user'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address'        => 'required|string|min:5',
            'phone'          => 'required|string|min:9',
            'payment_method' => 'required|in:cash,click,payme',
            'note'           => 'nullable|string|max:500',
        ]);

        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['food', 'restaurant'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index');
        }

        $subtotal         = $cartItems->sum(fn($i) => ($i->food->discount_price ?? $i->food->price) * $i->quantity);
        $delivery         = $cartItems->first()?->restaurant?->delivery_fee ?? 0;
        $total            = $subtotal + $delivery;
        $commission       = round($total * self::COMMISSION);
        $restaurantAmount = $total - $commission;

        DB::beginTransaction();
        try {
            // Order yaratish
            $order = Order::create([
                'user_id'           => auth()->id(),
                'restaurant_id'     => $cartItems->first()->restaurant_id,
                'subtotal'          => $subtotal,
                'delivery_fee'      => $delivery,
                'total'             => $total,
                'commission'        => $commission,
                'restaurant_amount' => $restaurantAmount,
                'status'            => 'pending',
                'payment_method'    => $request->payment_method,
                'payment_status'    => 'unpaid',
                'address'           => $request->address,
                'phone'             => $request->phone,
                'note'              => $request->note,
            ]);

            // Order items yaratish
            foreach ($cartItems as $item) {
                $price = $item->food->discount_price ?? $item->food->price;
                OrderItem::create([
                    'order_id'  => $order->id,
                    'food_id'   => $item->food_id,
                    'quantity'  => $item->quantity,
                    'price'     => $price,
                    'total'     => $price * $item->quantity,
                ]);
            }

            // Savatni tozalash
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            // To'lov usuliga qarab yo'naltirish
            if ($request->payment_method === 'cash') {
                return redirect()->route('payment.success', $order->id);
            }

            if ($request->payment_method === 'click') {
                $click = new ClickService();
                $url   = $click->createPaymentUrl($order->id, $order->total);
                return redirect($url);
            }

            if ($request->payment_method === 'payme') {
                $payme = new PaymeService();
                $url   = $payme->createPaymentUrl($order->id, $order->total);
                return redirect($url);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    // To'lov muvaffaqiyatli
    public function success($orderId)
    {
        $order = Order::with(['items.food', 'restaurant'])->findOrFail($orderId);
        return view('user.payment_success', compact('order'));
    }

    // To'lov muvaffaqiyatsiz
    public function failed($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('user.payment_failed', compact('order'));
    }
}