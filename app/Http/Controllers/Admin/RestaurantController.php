<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('user')->latest()->paginate(10);
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        $owners = User::where('role', 'owner')->get();
        return view('admin.restaurants.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'user_id'      => 'required|exists:users,id',
            'phone'        => 'nullable|string',
            'address'      => 'nullable|string',
            'delivery_fee' => 'nullable|numeric',
            'delivery_time'=> 'nullable|integer',
            'image'        => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . rand(100, 999);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('restaurants', 'public');
        }

        Restaurant::create($data);
        return redirect()->route('admin.restaurants.index')->with('success', 'Restoran qo\'shildi!');
    }

    public function edit(Restaurant $restaurant)
    {
        $owners = User::where('role', 'owner')->get();
        return view('admin.restaurants.edit', compact('restaurant', 'owners'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('restaurants', 'public');
        }
        $restaurant->update($data);
        return redirect()->route('admin.restaurants.index')->with('success', 'Restoran yangilandi!');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return back()->with('success', 'Restoran o\'chirildi!');
    }

    public function toggleStatus(Restaurant $restaurant)
    {
        $restaurant->update(['is_active' => !$restaurant->is_active]);
        return back()->with('success', 'Status yangilandi!');
    }
}