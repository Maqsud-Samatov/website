<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        if (!$restaurant) return redirect()->route('owner.dashboard');
        
        $categories = $restaurant->categories()->with('foods')->get();
        $allFoods   = $restaurant->foods()->with('category')->latest()->get();
        
        return view('owner.menu.index', compact('restaurant', 'categories', 'allFoods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:3048',
        ]);

        $restaurant = auth()->user()->restaurant;
        $data = $request->all();
        $data['restaurant_id'] = $restaurant->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        Food::create($data);
        return back()->with('success', 'Taom qo\'shildi!');
    }

    public function edit(Food $food)
    {
        $restaurant = auth()->user()->restaurant;
        $categories = $restaurant->categories()->get();
        return response()->json([
            'food'       => $food,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Food $food)
    {
        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods', 'public');
        }
        $food->update($data);
        return back()->with('success', 'Taom yangilandi!');
    }

    public function destroy(Food $food)
    {
        $food->delete();
        return back()->with('success', 'Taom o\'chirildi!');
    }

    public function toggle(Food $food)
    {
        $food->update(['is_available' => !$food->is_available]);
        return back()->with('success', 'Status yangilandi!');
    }
}