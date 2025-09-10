<?php

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Index as DashboardIndex;
Use App\Livewire\Users\Index as UsersIndex;
Use App\Livewire\Users\Create as UsersCreate;
Use App\Livewire\Users\Edit as UsersEdit;

Route::get("/", function () {
    return redirect()->route('admin.dashboard.index');
});

Route::get('/login', Login::class)->name('login');
Route::get('/logout', [Login::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard.index');
    Route::get('/users', UsersIndex::class)->name('users.index');
    Route::get('/users/create', UsersCreate::class)->name('users.create');
    Route::get('/users/edit/{id}', UsersEdit::class)->name('users.edit');
});

