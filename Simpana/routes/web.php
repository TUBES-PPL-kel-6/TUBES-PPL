<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use Illuminate\Support\Facades\Route;



Route::get('/register', [RegistController::class, 'showForm']);
Route::post('/register', [RegistController::class, 'submitForm']);

Route::get('/dashboard', function () {
    return view('layout.index');
  
  
Route::get('/', function () {
    return view('landingPage');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/payment', function () {
    return view('payment');
});
