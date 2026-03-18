<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\User\UserController;

// Bosh sahifa — HomeController ga yo'naltiring
Route::get('/', [\App\Http\Controllers\User\HomeController::class, 'index']);

// Auth routes (login, register)
require __DIR__.'/auth.php';

// Dashboard — role ga qarab yo'naltiradi
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    return match($role) {
        'admin'    => redirect('/admin/dashboard'),
        'owner'    => redirect('/owner/dashboard'),
        'delivery' => redirect('/delivery/dashboard'),
        default    => redirect('/'),   // ← user → welcome page ga
    };
})->middleware('auth')->name('dashboard');


// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Restaurants
    Route::resource('restaurants', \App\Http\Controllers\Admin\RestaurantController::class);
    Route::post('restaurants/{restaurant}/toggle', [\App\Http\Controllers\Admin\RestaurantController::class, 'toggleStatus'])->name('restaurants.toggle');

    // Users
    Route::get('/users', function() {
        $users = \App\Models\User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    })->name('users.index');

    Route::post('/users/{user}/role', function(\App\Models\User $user, \Illuminate\Http\Request $request) {
        $user->update(['role' => $request->role]);
        return back()->with('success', 'Role yangilandi!');
    })->name('users.role');

    // Orders
    Route::get('/orders', function() {
        $orders = \App\Models\Order::with(['user', 'restaurant'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    })->name('orders.index');

    Route::post('/orders/{order}/status', function(\App\Models\Order $order, \Illuminate\Http\Request $request) {
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status yangilandi!');
    })->name('orders.status');

    Route::get('/orders/{order}', function(\App\Models\Order $order) {
        $order->load(['user', 'restaurant', 'items.food']);
        return view('admin.orders.show', compact('order'));
    })->name('orders.show');

});

// Owner routes
Route::prefix('owner')->middleware(['auth', 'owner'])->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::post('/categories', [\App\Http\Controllers\Owner\RestaurantController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [\App\Http\Controllers\Owner\RestaurantController::class, 'destroyCategory'])->name('categories.destroy');
    
    // Foods
    Route::get('/menu', [\App\Http\Controllers\Owner\FoodController::class, 'index'])->name('menu.index');
    Route::post('/foods', [\App\Http\Controllers\Owner\FoodController::class, 'store'])->name('foods.store');
    Route::get('/foods/{food}/edit', [\App\Http\Controllers\Owner\FoodController::class, 'edit'])->name('foods.edit');
    Route::put('/foods/{food}', [\App\Http\Controllers\Owner\FoodController::class, 'update'])->name('foods.update');
    Route::delete('/foods/{food}', [\App\Http\Controllers\Owner\FoodController::class, 'destroy'])->name('foods.destroy');
    Route::post('/foods/{food}/toggle', [\App\Http\Controllers\Owner\FoodController::class, 'toggle'])->name('foods.toggle');
});

// Delivery routes
Route::prefix('delivery')->middleware(['auth', 'delivery'])->group(function () {
    Route::get('/dashboard', [DeliveryController::class, 'index'])->name('delivery.dashboard');
});

// User routes
Route::prefix('user')->middleware(['auth'])->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // Cart
    Route::get('/cart', [\App\Http\Controllers\User\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [\App\Http\Controllers\User\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [\App\Http\Controllers\User\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [\App\Http\Controllers\User\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\User\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [\App\Http\Controllers\User\CartController::class, 'count'])->name('cart.count');
    Route::get('/orders', [\App\Http\Controllers\User\OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/confirm', [\App\Http\Controllers\User\OrderController::class, 'confirm'])->name('orders.confirm');
});
// Payment routes (auth shart emas — Click/Payme serveridan keladi)
Route::prefix('payment')->name('payment.')->group(function () {

    // Click webhooks
    Route::post('/click/prepare',  [\App\Http\Controllers\Payment\ClickController::class, 'prepare'])->name('click.prepare');
    Route::post('/click/complete', [\App\Http\Controllers\Payment\ClickController::class, 'complete'])->name('click.complete');
    Route::get('/click/return',    [\App\Http\Controllers\Payment\ClickController::class, 'return'])->name('click.return');

    // Payme webhook
    Route::post('/payme',          [\App\Http\Controllers\Payment\PaymeController::class, 'webhook'])->name('payme.webhook');
    Route::get('/payme/return',    [\App\Http\Controllers\Payment\PaymeController::class, 'return'])->name('payme.return');

    // Success/Failed
    Route::get('/success/{orderId}', [\App\Http\Controllers\User\CheckoutController::class, 'success'])->name('success');
    Route::get('/failed/{orderId}',  [\App\Http\Controllers\User\CheckoutController::class, 'failed'])->name('failed');
});

// Checkout (auth kerak)
Route::prefix('user')->middleware(['auth'])->name('user.')->group(function () {
    // ... mavjud routelar ...
    Route::get('/checkout',  [\App\Http\Controllers\User\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\User\CheckoutController::class, 'store'])->name('checkout.store');
});
// Delivery routes
Route::prefix('delivery')->middleware(['auth', 'delivery'])->name('delivery.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Delivery\DeliveryController::class, 'index'])->name('dashboard');
    Route::post('/orders/{order}/accept',  [\App\Http\Controllers\Delivery\DeliveryController::class, 'accept'])->name('accept');
    Route::post('/orders/{order}/pickup',  [\App\Http\Controllers\Delivery\DeliveryController::class, 'pickup'])->name('pickup');
    Route::post('/orders/{order}/deliver', [\App\Http\Controllers\Delivery\DeliveryController::class, 'deliver'])->name('deliver');
    Route::get('/history', [\App\Http\Controllers\Delivery\DeliveryController::class, 'history'])->name('history');
});