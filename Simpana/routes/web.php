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
use App\Http\Controllers\ShuController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\LoanPaymentController;
use App\Http\Controllers\ProfitReportController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminSetoranController;
use App\Http\Controllers\RiwayatPinjamanController;
use App\Http\Controllers\RiwayatSimpananController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Landing page
Route::get('/', function () {
    return view('landingPage');
});

// Authentication routes
Route::middleware('guest')->group(function () {
   Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [RegistController::class, 'showForm'])->name('register');
    Route::post('/register', [RegistController::class, 'store']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Complaint routes
Route::get('/complaint', [ComplaintController::class, 'showForm'])->name('complaint.create');
Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');

// Payment routes
Route::get('/payment', [simpPokokController::class, 'show'])->name('payment.show');
Route::post('/payment/process', [simpPokokController::class, 'process'])->name('payment.process');

// User routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
   // Route::get('/login', function () {
     //   if (!Auth::check()) {
     //       return redirect()->route('login');
     //   }

     //   return auth()->user()->role === 'admin'
     //       ? redirect()->route('admin.index')
     //       : redirect()->route('user.dashboard');
     //   })->name('dashboard');

    // User dashboard
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/riwayat-pinjaman', [RiwayatPinjamanController::class, 'index'])->name('riwayat-pinjaman.index');
        Route::get('/riwayat-simpanan', [RiwayatSimpananController::class, 'index'])->name('riwayat-simpanan.index');
    });

    // Main dashboard route
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Loan Application Routes
    Route::prefix('loan')->name('loan.')->group(function () {
        Route::get('/', [LoanApplicationController::class, 'create'])->name('create');
        Route::post('/', [LoanApplicationController::class, 'store'])->name('store');
        Route::get('/{loanApplication}', [LoanApplicationController::class, 'show'])->name('show');
        Route::get('/{loanApplication}/edit', [LoanApplicationController::class, 'edit'])->name('edit');
        Route::put('/{loanApplication}', [LoanApplicationController::class, 'update'])->name('update');
        Route::delete('/{loanApplication}', [LoanApplicationController::class, 'destroy'])->name('destroy');
    });

    // Loan Payment Routes
    Route::prefix('loan-payments')->name('loan-payments.')->group(function () {
        Route::get('/', [LoanPaymentController::class, 'index'])->name('index');
        Route::get('/create/{loan}', [LoanPaymentController::class, 'create'])->name('create');
        Route::post('/{loan}', [LoanPaymentController::class, 'store'])->name('store');
        Route::get('/resubmit/{payment}', [LoanPaymentController::class, 'resubmit'])->name('resubmit');
    });

    // Discussion routes
    Route::prefix('discussion')->name('discussion.')->group(function () {
        Route::get('/', [DiscussionController::class, 'index'])->name('index');
        Route::post('/', [DiscussionController::class, 'store'])->name('store');
        Route::get('/{discussion}/edit', [DiscussionController::class, 'edit'])->name('edit');
        Route::put('/{discussion}', [DiscussionController::class, 'update'])->name('update');
        Route::delete('/{discussion}', [DiscussionController::class, 'destroy'])->name('destroy');
        Route::post('/{discussion}/comment', [DiscussionCommentController::class, 'store'])->name('comment.store');
    });

    // Dashboard features
    Route::prefix('dashboard')->name('dashboard.')->group(function() {
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/simpanan', [DashboardController::class, 'simpanan'])->name('simpanan');
        Route::get('/simpanan/create', [DashboardController::class, 'createSimpanan'])->name('simpanan.create');
        Route::post('/simpanan', [DashboardController::class, 'storeSimpanan'])->name('simpanan.store');
        Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
        Route::get('/shu', [DashboardController::class, 'shu'])->name('shu');
        Route::get('/shu/download-pdf/{tahun}', [DashboardController::class, 'downloadShuPdf'])->name('shu.download_pdf');
    });

    // Notifications
    Route::get('/notifications', [UserController::class, 'showNotifications'])->name('notifications');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Profit Report
    Route::get('/profit-report', [ProfitReportController::class, 'index'])->name('profit-report.index');
    Route::get('/profit-report/chart', [ProfitReportController::class, 'getChartData'])->name('profit-report.chart');

    // Loan Approval
    Route::get('/loan-approval', [LoanApplicationController::class, 'index'])->name('loanApproval');
    Route::post('/loan-approval/{loanApplication}/approve', [LoanApplicationController::class, 'approve'])->name('loanApproval.approve');
    Route::post('/loan-approval/{loanApplication}/reject', [LoanApplicationController::class, 'reject'])->name('loanApproval.reject');

    // User management
    Route::get('/users', [UserController::class, 'listUsers'])->name('users');
    Route::post('/users/{id}/remind', [UserController::class, 'remindUser'])->name('users.remind');

    // Payment verification
    Route::get('/payments', [LoanPaymentController::class, 'adminVerification'])->name('payment-verification');
    Route::get('/payments/{payment}', [LoanPaymentController::class, 'getPaymentDetails']);
    Route::post('/payments/{payment}/verify', [LoanPaymentController::class, 'verify'])->name('payment.verify');
    Route::post('/payments/{payment}/reject', [LoanPaymentController::class, 'reject'])->name('payment.reject');

    // SHU management
    Route::get('/shu', [ShuController::class, 'index'])->name('shu.index');
    Route::get('/shu/generate', [ShuController::class, 'showGenerateForm'])->name('shu.form');
    Route::post('/shu/generate', [ShuController::class, 'generate'])->name('shu.generate');
    Route::post('/shu/generate-pdf', [ShuController::class, 'generatePDF'])->name('shu.generatePDF');

    // Acceptance management
    Route::get('/acceptance', [AcceptanceController::class, 'index'])->name('acceptance.index');
    Route::get('/acceptance/approve/{id}', [AcceptanceController::class, 'approve'])->name('acceptance.approve');
    Route::get('/acceptance/reject/{id}', [AcceptanceController::class, 'reject'])->name('acceptance.reject');

    // Setoran management
    Route::resource('setoran', AdminSetoranController::class);
});
