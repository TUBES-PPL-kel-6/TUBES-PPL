<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\simpPokokController;
use App\Http\Controllers\AcceptanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\DiscussionCommentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ProfitReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SimpananController;
use App\Models\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

// Public routes
Route::get('/', function () {
    return view('landingPage');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegistController::class, 'showForm'])->name('register');
Route::post('/register', [RegistController::class, 'store']);

// Payment routes (public)
Route::get('/payment', [simpPokokController::class, 'show'])->name('payment.show');
Route::post('/payment/process', [simpPokokController::class, 'process'])->name('payment.process');

// Dashboard redirect route
Route::get('/dashboard', function () {
    if (auth()->user() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.index');
    }
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');

// User routes
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/user', function () {
        return view('layouts.dashboard');
    })->name('user.dashboard');

    Route::prefix('dashboard')->group(function () {
        Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
        Route::get('/simpanan', [DashboardController::class, 'simpanan'])->name('dashboard.simpanan');
        Route::get('/simpanan/create', [DashboardController::class, 'createSimpanan'])->name('dashboard.simpanan.create');
        Route::post('/simpanan', [DashboardController::class, 'storeSimpanan'])->name('dashboard.simpanan.store');
        Route::get('/transactions', [DashboardController::class, 'transactions'])->name('dashboard.transactions');
    });

    // Loan routes
    Route::prefix('loan')->group(function () {
        Route::get('/', [LoanApplicationController::class, 'create'])->name('loan.create');
        Route::post('/', [LoanApplicationController::class, 'store'])->name('loan.store');
        Route::get('/{loanApplication}', [LoanApplicationController::class, 'show'])->name('loan.show');
        Route::get('/{loanApplication}/edit', [LoanApplicationController::class, 'edit'])->name('loan.edit');
        Route::put('/{loanApplication}', [LoanApplicationController::class, 'update'])->name('loan.update');
        Route::delete('/{loanApplication}', [LoanApplicationController::class, 'destroy'])->name('loan.destroy');
        Route::get('/{loanApplication}/download-approval-letter', [LoanApplicationController::class, 'downloadApprovalLetter'])->name('loan.downloadApprovalLetter');
    });

    // Discussion routes
    Route::prefix('discussion')->group(function () {
        Route::get('/', [DiscussionController::class, 'index'])->name('discussion.index');
        Route::post('/', [DiscussionController::class, 'store'])->name('discussion.store');
        Route::get('/{discussion}/edit', [DiscussionController::class, 'edit'])->name('discussion.edit');
        Route::put('/{discussion}', [DiscussionController::class, 'update'])->name('discussion.update');
        Route::delete('/{discussion}', [DiscussionController::class, 'destroy'])->name('discussion.destroy');
        Route::post('/{discussion}/comment', [DiscussionCommentController::class, 'store'])->name('discussion.comment.store');
    });

    // Notification routes
    Route::prefix('notifications')->group(function () {
        Route::get('/', [UserController::class, 'showNotifications'])->name('notifications');
        Route::get('/simpanan', function () {
            return view('notifications', ['type' => 'simpanan']);
        })->name('notifications.simpanan');
        Route::get('/pinjaman', function () {
            return view('notifications', ['type' => 'pinjaman']);
        })->name('notifications.pinjaman');
        Route::get('/general', [UserController::class, 'showGeneralNotifications'])->name('notifications.general');
    });

    // Complaint routes
    Route::get('/complaint', [ComplaintController::class, 'showForm'])->name('complaint.create');
    Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');

    // Additional Simpanan routes
    Route::prefix('dashboard')->name('dashboard.')->group(function() {
        Route::get('/simpanan', [SimpananController::class, 'index'])->name('simpanan');
        Route::get('/simpanan/create', [SimpananController::class, 'create'])->name('simpanan.create');
        Route::post('/simpanan', [SimpananController::class, 'store'])->name('simpanan.store');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // User management
    Route::get('/users', [UserController::class, 'listUsers'])->name('admin.users');
    Route::post('/users/{id}/remind', [UserController::class, 'remindUser'])->name('admin.users.remind');

    // Member acceptance
    Route::get('/acceptance', [AcceptanceController::class, 'index'])->name('acceptance.index');
    Route::get('/acceptance/approve/{id}', [AcceptanceController::class, 'approve'])->name('acceptance.approve');
    Route::get('/acceptance/reject/{id}', [AcceptanceController::class, 'reject'])->name('acceptance.reject');

    // Loan approval
    Route::get('/loan-approval', [LoanApplicationController::class, 'index'])->name('loanApproval');
    Route::post('/loan-approval/{loanApplication}/approve', [LoanApplicationController::class, 'approve'])->name('loanApproval.approve');
    Route::post('/loan-approval/{loanApplication}/reject', [LoanApplicationController::class, 'reject'])->name('loanApproval.reject');

    // Profit reports
    Route::get('/profit-report', [ProfitReportController::class, 'index'])->name('profit-report.index');
    Route::get('/profit-report/chart', [ProfitReportController::class, 'getChartData'])->name('profit-report.chart');
});

// Additional routes
Route::get('/admin-loan-applications', function () {
    return view('admin-loan-application');
});

Route::get('/general', function () {
    return view('payment-form');
})->name('payment-form');




