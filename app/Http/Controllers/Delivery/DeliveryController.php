<?php
namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // Dashboard — yangi buyurtmalar
    public function index()
    {
        $newOrders = Order::with(['user', 'restaurant', 'items.food'])
            ->where('status', 'preparing')
            ->whereNull('delivery_user_id')
            ->latest()
            ->get();

        $myOrders = Order::with(['user', 'restaurant', 'items.food'])
            ->where('delivery_user_id', auth()->id())
            ->whereIn('status', ['confirmed', 'on_the_way'])
            ->latest()
            ->get();

        $completedToday = Order::where('delivery_user_id', auth()->id())
            ->where('status', 'delivered')
            ->whereDate('delivered_at', today())
            ->count();

        $earningsToday = Order::where('delivery_user_id', auth()->id())
            ->where('status', 'delivered')
            ->whereDate('delivered_at', today())
            ->sum('delivery_fee');

        return view('delivery.dashboard', compact(
            'newOrders', 'myOrders', 'completedToday', 'earningsToday'
        ));
    }

    // Buyurtmani qabul qilish
    public function accept(Order $order)
    {
        if ($order->delivery_user_id) {
            return back()->with('error', 'Bu buyurtma allaqachon qabul qilingan!');
        }

        $order->update([
            'delivery_user_id' => auth()->id(),
            'status'           => 'on_the_way',
        ]);

        return back()->with('success', 'Buyurtma qabul qilindi!');
    }

    // Zakasni oldim — yo'lda
    public function pickup(Order $order)
    {
        if ($order->delivery_user_id !== auth()->id()) {
            return back()->with('error', 'Ruxsat yo\'q!');
        }

        $order->update([
            'status'       => 'on_the_way',
            'picked_up_at' => now(),
        ]);

        return back()->with('success', 'Yetkazib berish boshlandi!');
    }

    // Yetkazib berdim
    public function deliver(Order $order)
    {
        if ($order->delivery_user_id !== auth()->id()) {
            return back()->with('error', 'Ruxsat yo\'q!');
        }

        $order->update([
            'status'       => 'delivered',
            'delivered_at' => now(),
        ]);

        return back()->with('success', 'Buyurtma yetkazildi! Mijoz tasdiqlashini kuting.');
    }

    // Buyurtma tarixi
    public function history()
    {
        $orders = Order::with(['user', 'restaurant'])
            ->where('delivery_user_id', auth()->id())
            ->where('status', 'delivered')
            ->latest()
            ->paginate(15);

        return view('delivery.history', compact('orders'));
    }

    // Buyurtma detali
    public function show(Order $order)
    {
        if ($order->delivery_user_id !== auth()->id()) {
            return back()->with('error', 'Ruxsat yo\'q!');
        }

        $order->load(['user', 'restaurant', 'items.food']);
        return view('delivery.show', compact('order'));
    }
}