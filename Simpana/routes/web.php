<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/register', [RegistController::class, 'showForm']);
Route::post('/register', [RegistController::class, 'store']);


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
Route::get('/dashboard/simpanan', [DashboardController::class, 'simpanan'])->name('dashboard.simpanan');
Route::get('/dashboard/simpanan/create', [DashboardController::class, 'createSimpanan'])->name('dashboard.simpanan.create');
Route::post('/dashboard/simpanan', [DashboardController::class, 'storeSimpanan'])->name('dashboard.simpanan.store');
Route::get('/dashboard/transactions', [DashboardController::class, 'transactions'])->name('dashboard.transactions');

Route::get('/', function () {
    return view('landingPage');
});

Route::get('/login', function () {
    return view('login');
});
// web.php
Route::post('/login', [RegistController::class, 'login']);


Route::get('/payment', function () {
    return view('payment');
});

Route::get('/user', function () {
    return view('layouts.dashboard');
});

