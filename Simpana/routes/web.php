<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\simpPokokController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanApplicationController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    return view('layouts.dashboard');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
});

// Member routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/user/transactions', [UserController::class, 'transactions'])->name('user.transactions');
    Route::post('/user/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

// Gunakan resource route saja
Route::resource('loan', LoanApplicationController::class);

