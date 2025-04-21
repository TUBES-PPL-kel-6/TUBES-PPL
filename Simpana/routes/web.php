<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\simpPokokController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/register', [RegistController::class, 'showForm'])->name('register');
Route::post('/register', [RegistController::class, 'store']);

// Home route
Route::get('/', function () {
    return view('landingPage');
});

// Login routes
Route::get('/login', function () {
    return view('login'); 
})->name('login');

Route::post('/login', [RegistController::class, 'login'])->name('login.post');

// Payment routes - fixed duplicate routes
Route::get('/payment', [RegistController::class, 'showPaymentPage'])->name('payment.show');
Route::post('/payment', [simpPokokController::class, 'process'])->name('payment.process');

// Dashboard route - this will handle the redirection based on role
Route::get('/dashboard', function () {
    if (auth()->user() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.index');
    }
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');

// User dashboard - requires authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/user', function () {
        return view('layouts.dashboard');
    })->name('user.dashboard');
});

// Admin routes - requires admin role
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    // Add other admin routes here
});

// Add this route for debugging
Route::get('/check-role', function () {
    if (Auth::check()) {
        return "User is logged in. Role: " . Auth::user()->role;
    }
    return "User is not logged in.";
})->middleware('auth');

