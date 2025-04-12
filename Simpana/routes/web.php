<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use Illuminate\Support\Facades\Route;


Route::get('/register', [RegistController::class, 'showForm']);
Route::post('/register', [RegistController::class, 'store']);


Route::get('/dashboard', function () {
    return view('admin.index');
});

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

