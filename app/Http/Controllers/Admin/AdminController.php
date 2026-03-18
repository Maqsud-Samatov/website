<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\Food;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users'       => User::count(),
            'restaurants' => Restaurant::count(),
            'orders'      => Order::count(),
            'foods'       => Food::count(),
            'revenue'     => Order::where('status', 'delivered')->sum('total'),
            'pending'     => Order::where('status', 'pending')->count(),
        ];

        $recentOrders    = Order::with(['user', 'restaurant'])->latest()->take(8)->get();
        $recentUsers     = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentUsers'));
    }
}