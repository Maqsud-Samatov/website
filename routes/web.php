<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\User\UserController;

// Bosh sahifa
Route::get('/', function () {
    return view('welcome');
});

// Auth routes (login, register)
require __DIR__.'/auth.php';

// Dashboard — role ga qarab yo'naltiradi
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    return match($role) {
        'admin'    => redirect('/admin/dashboard'),
        'owner'    => redirect('/owner/dashboard'),
        'delivery' => redirect('/delivery/dashboard'),
        default    => redirect('/user/dashboard'),
    };
})->middleware('auth')->name('dashboard');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Owner routes
Route::prefix('owner')->middleware(['auth', 'owner'])->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
});

// Delivery routes
Route::prefix('delivery')->middleware(['auth', 'delivery'])->group(function () {
    Route::get('/dashboard', [DeliveryController::class, 'index'])->name('delivery.dashboard');
});

// User routes
Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});