<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OwnerController extends Controller
{
    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return view('owner.setup');
        }

        $stats = [
            'foods'    => $restaurant->foods()->count(),
            'orders'   => $restaurant->orders()->count(),
            'pending'  => $restaurant->orders()->where('status', 'pending')->count(),
            'revenue'  => $restaurant->orders()->where('status', 'delivered')->sum('total'),
        ];

        $recentOrders = $restaurant->orders()->with('user')->latest()->take(8)->get();

        return view('owner.dashboard', compact('restaurant', 'stats', 'recentOrders'));
    }
}