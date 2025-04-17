<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\simpPokokController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegistController::class, 'showForm'])->name('register');
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
Route::post('/login', [RegistController::class, 'login'])->name('login');


// Route::get('/payment', function () {
//     return view('payment');
// });
Route::get('/payment', [simpPokokController::class, 'show'])->name('payment.show');
Route::post('/payment', [simpPokokController::class, 'process'])->name('payment.process');
Route::get('/payment', [RegistController::class, 'showPaymentPage'])->name('payment.show');



Route::get('/user', function () {
    return view('layouts.dashboard');})->name('user.dashboard');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');
    // Add other admin routes here
});

