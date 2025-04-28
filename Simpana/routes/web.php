<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegistController::class, 'showForm']);
Route::post('/register', [RegistController::class, 'store']);
Route::get('/acceptance', [AcceptanceController::class, 'index'])->name('acceptance.index');
Route::get('/acceptance/approve/{id}', [AcceptanceController::class, 'approve'])->name('acceptance.approve');
Route::get('/acceptance/reject/{id}', [AcceptanceController::class, 'reject'])->name('acceptance.reject');

// Complaint Routes
Route::get('/complaint', [ComplaintController::class, 'showForm'])->name('complaint.create');
Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');

Route::get('/dashboard', function () {
    return view('admin.index');
});

Route::get('/', function () {
    return view('landingPage');
});

// Login routes
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [RegistController::class, 'login'])->name('login.post');


Route::get('/payment', function () {
    return view('payment');
});


Route::get('/user', function () {
    return view('layouts.dashboard');
});