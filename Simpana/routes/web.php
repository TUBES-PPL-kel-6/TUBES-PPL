<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\simpPokokController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcceptanceController;

Route::get('/register', [RegistController::class, 'showForm'])->name('register');
Route::post('/register', [RegistController::class, 'store']);
Route::get('/acceptance', [AcceptanceController::class, 'index'])->name('acceptance.index');
Route::get('/acceptance/approve/{id}', [AcceptanceController::class, 'approve'])->name('acceptance.approve');
Route::get('/acceptance/reject/{id}', [AcceptanceController::class, 'reject'])->name('acceptance.reject');



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
Route::post('/login', [RegistController::class, 'login'])->name('login');


// Route::get('/payment', function () {
//     return view('payment');
// });
Route::get('/payment', [simpPokokController::class, 'show'])->name('payment.show');
Route::post('/payment', [simpPokokController::class, 'process'])->name('payment.process');
Route::get('/payment', [RegistController::class, 'showPaymentPage'])->name('payment.show');



Route::get('/user', function () {
    return view('layouts.dashboard');
});

