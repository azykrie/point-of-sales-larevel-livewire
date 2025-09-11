<?php

use App\Livewire\Auth\Login;

Route::get("/", function () {
    return redirect()->route('admin.dashboard.index');
});

Route::get('/login', Login::class)->name('login');
Route::get('/logout', [Login::class, 'logout'])->name('logout');

// Admin Routes

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', App\Livewire\Dashboard\Index::class)->name('dashboard.index');
    Route::get('/users', App\Livewire\Users\Index::class)->name('users.index');
    Route::get('/users/create', App\Livewire\Users\Create::class)->name('users.create');
    Route::get('/users/edit/{id}', App\Livewire\Users\Edit::class)->name('users.edit');
    Route::get('categories', App\Livewire\Categories\Index::class)->name('categories.index');
    Route::get('categories/create', App\Livewire\Categories\Create::class)->name('categories.create');
    Route::get('categories/edit/{id}', App\Livewire\Categories\Edit::class)->name('categories.edit');
    Route::get('products', App\Livewire\Products\Index::class)->name('products.index');
    Route::get('products/create', App\Livewire\Products\Create::class)->name('products.create');
    Route::get('products/edit/{id}', App\Livewire\Products\Edit::class)->name('products.edit');
    Route::get('suppliers', App\Livewire\Suppliers\Index::class)->name('suppliers.index');
    Route::get('suppliers/create', App\Livewire\Suppliers\Create::class)->name('suppliers.create');
    Route::get('suppliers/edit/{id}', App\Livewire\Suppliers\Edit::class)->name('suppliers.edit');
    Route::get('purchases', App\Livewire\Purchases\Index::class)->name('purchases.index');
    Route::get('purchases/create', App\Livewire\Purchases\Create::class)->name('purchases.create');
    Route::get('purchases/edit/{id}', App\Livewire\Purchases\Edit::class)->name('purchases.edit');
    Route::get('purchases/show/{id}', App\Livewire\Purchases\Show::class)->name('purchases.show');
});


// WareHouse Routes

Route::prefix('warehouse')->name('warehouse.')->middleware(['auth', 'role:warehouse'])->group(function () {
    Route::get('/dashboard', App\Livewire\Dashboard\Index::class)->name('dashboard.index');
    Route::get('categories', App\Livewire\Categories\Index::class)->name('categories.index');
    Route::get('categories/create', App\Livewire\Categories\Create::class)->name('categories.create');
    Route::get('categories/edit/{id}', App\Livewire\Categories\Edit::class)->name('categories.edit');
    Route::get('products', App\Livewire\Products\Index::class)->name('products.index');
    Route::get('products/create', App\Livewire\Products\Create::class)->name('products.create');
    Route::get('products/edit/{id}', App\Livewire\Products\Edit::class)->name('products.edit');
    Route::get('suppliers', App\Livewire\Suppliers\Index::class)->name('suppliers.index');
    Route::get('suppliers/create', App\Livewire\Suppliers\Create::class)->name('suppliers.create');
    Route::get('suppliers/edit/{id}', App\Livewire\Suppliers\Edit::class)->name('suppliers.edit');
    Route::get('purchases', App\Livewire\Purchases\Index::class)->name('purchases.index');
    Route::get('purchases/create', App\Livewire\Purchases\Create::class)->name('purchases.create');
    Route::get('purchases/edit/{id}', App\Livewire\Purchases\Edit::class)->name('purchases.edit');
    Route::get('purchases/show/{id}', App\Livewire\Purchases\Show::class)->name('purchases.show');
});