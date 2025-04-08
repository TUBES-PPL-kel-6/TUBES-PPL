<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistController;


Route::get('/register', [RegistController::class, 'showForm']);
Route::post('/register', [RegistController::class, 'store']);

Route::get('/dashboard', function () {
    return view('layout.index');
});  
  
Route::get('/', function () {
    return view('landingPage');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/payment', function () {
    return view('payment');
});