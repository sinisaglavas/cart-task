<?php

use App\Livewire\CartPage;
use App\Livewire\ProductsPage;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/products', ProductsPage::class)->name('products');
    Route::get('/cart', CartPage::class)->name('cart');
});

require __DIR__.'/auth.php';
