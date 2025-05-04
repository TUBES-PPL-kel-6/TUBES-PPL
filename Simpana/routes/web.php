<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\simpPokokController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AcceptanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;


// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegistController::class, 'showForm'])->name('register');
Route::post('/register', [RegistController::class, 'store']);
Route::get('/acceptance', [AcceptanceController::class, 'index'])->name('acceptance.index');
Route::get('/acceptance/approve/{id}', [AcceptanceController::class, 'approve'])->name('acceptance.approve');
Route::get('/acceptance/reject/{id}', [AcceptanceController::class, 'reject'])->name('acceptance.reject');

// Complaint Routes
Route::get('/complaint', [ComplaintController::class, 'showForm'])->name('complaint.create');
Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');

// Home route
Route::get('/', function () {
    return view('landingPage');
});

// Login routes
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [RegistController::class, 'login'])->name('login.post');

// Payment routes
Route::get('/payment', [simpPokokController::class, 'show'])->name('payment.show');
Route::post('/payment/process', [simpPokokController::class, 'process'])->name('payment.process');

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

    // Loan Application Routes
    Route::get('/loan', [LoanApplicationController::class, 'create'])->name('loan.create');
    Route::post('/loan', [LoanApplicationController::class, 'store'])->name('loan.store');
    Route::get('/loan/{loanApplication}', [LoanApplicationController::class, 'show'])->name('loan.show');
    Route::get('/loan/{loanApplication}/edit', [LoanApplicationController::class, 'edit'])->name('loan.edit');
    Route::put('/loan/{loanApplication}', [LoanApplicationController::class, 'update'])->name('loan.update');
    Route::delete('/loan/{loanApplication}', [LoanApplicationController::class, 'destroy'])->name('loan.destroy');
});

// Admin routes - requires admin role
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Loan Approval Routes
    Route::get('/loanApproval', [LoanApplicationController::class, 'index'])->name('loanApproval');
    Route::post('/loanApproval/{loanApplication}/approve', [LoanApplicationController::class, 'approve'])->name('loanApproval.approve');
    Route::post('/loanApproval/{loanApplication}/reject', [LoanApplicationController::class, 'reject'])->name('loanApproval.reject');
});
