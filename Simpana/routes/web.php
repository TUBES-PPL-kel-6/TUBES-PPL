<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

<<<<<<< Updated upstream
=======
// Public routes
>>>>>>> Stashed changes
Route::get('/', function () {
    return view('welcome');
});
<<<<<<< Updated upstream
=======

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [RegistController::class, 'login']);

Route::get('/register', [RegistController::class, 'showForm'])->name('register');
Route::post('/register', [RegistController::class, 'store']);

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::get('/dashboard/transactions', [DashboardController::class, 'transactions'])->name('dashboard.transactions');
    Route::get('/dashboard/simpanan', [DashboardController::class, 'simpanan'])->name('dashboard.simpanan');
    Route::get('/dashboard/simpanan/create', [DashboardController::class, 'createSimpanan'])->name('dashboard.simpanan.create');
    Route::post('/dashboard/simpanan', [DashboardController::class, 'storeSimpanan'])->name('dashboard.simpanan.store');
    
    // Logout route
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/')->with('success', 'Anda telah berhasil logout');
    })->name('logout');
});

Route::get('/payment', function () {
    return view('payment');
});

Route::get('/user', function () {
    return view('layouts.dashboard');
});

>>>>>>> Stashed changes
