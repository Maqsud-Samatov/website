<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;

class HomeController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::where('is_active', true)
            ->with(['categories.foods' => function($q) {
                $q->where('is_available', true);
            }])
            ->withCount('foods')
            ->get();

        return view('welcome', compact('restaurants'));
    }
}