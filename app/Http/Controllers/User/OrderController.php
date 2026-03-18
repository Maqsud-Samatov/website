<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    // Buyurtmalarim
    public function index()
    {
        $orders = Order::with(['restaurant', 'items.food'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }

    // Buyurtma detali
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        $order->load(['restaurant', 'items.food', 'delivery']);
        return view('user.order_detail', compact('order'));
    }

    // Qabul qildim — tasdiqlash
    public function confirm(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        if ($order->status !== 'delivered') {
            return back()->with('error', 'Buyurtma hali yetkazilmagan!');
        }

        $order->update([
            'user_confirmed'        => true,
            'confirmed_by_user_at'  => now(),
            'status'                => 'delivered',
        ]);

        return back()->with('success', 'Rahmat! Buyurtmani qabul qilganingiz tasdiqlandi.');
    }
}