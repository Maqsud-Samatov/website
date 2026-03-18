<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);

        $restaurant = auth()->user()->restaurant;

        $restaurant->categories()->create([
            'name'       => $request->name,
            'sort_order' => $restaurant->categories()->count(),
        ]);

        return back()->with('success', 'Kategoriya qo\'shildi!');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategoriya o\'chirildi!');
    }
}