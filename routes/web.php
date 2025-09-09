<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Protected routes with prefix and middleware
Route::middleware(['auth'])->prefix('user')->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/deposit', function () {
        return view('user.deposit');
    })->name('user.deposit');

    Route::get('/investment', function () {
        return view('user.investments');
    })->name('user.investments');

    Route::get('/wallets', function () {
        return view('user.wallets');
    })->name('user.wallets');

    Route::get('/transactions', function () {
        return view('user.transactions');
    })->name('user.transactions');

    Route::get('/notifications', function () {
        return view('user.notifications');
    })->name('user.notifications');

    Route::get('/markets', function () {
        return view('user.markets');
    })->name('user.markets');

    Route::get('/portfolio', function () {
        return view('user.portfolio');
    })->name('user.portfolio');

    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    Route::get('/search', function () {
        return view('user.search');
    })->name('user.search');
});