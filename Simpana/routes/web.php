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
// Landing page
Route::get('/', function () {
    return view('landingPage');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegistController::class, 'showForm'])->name('register');
Route::post('/register', [RegistController::class, 'store']);

// Complaint routes
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
    // Dashboard utama user (pakai closure, bukan controller)
    Route::get('/user', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Loan Application Routes
    Route::get('/loan', [LoanApplicationController::class, 'create'])->name('loan.create');
    Route::post('/loan', [LoanApplicationController::class, 'store'])->name('loan.store');
    Route::get('/loan/{loanApplication}', [LoanApplicationController::class, 'show'])->name('loan.show');
    Route::get('/loan/{loanApplication}/edit', [LoanApplicationController::class, 'edit'])->name('loan.edit');
    Route::put('/loan/{loanApplication}', [LoanApplicationController::class, 'update'])->name('loan.update');
    Route::delete('/loan/{loanApplication}', [LoanApplicationController::class, 'destroy'])->name('loan.destroy');
    Route::get('/loan/{loanApplication}/download-approval-letter', [LoanApplicationController::class, 'downloadApprovalLetter'])->name('loan.downloadApprovalLetter');

    // Loan Payment Routes - User side
    Route::get('/loan-payments', [LoanPaymentController::class, 'index'])->name('loan-payments.index');
    Route::get('/loan-payments/create/{loan}', [LoanPaymentController::class, 'create'])->name('loan-payments.create');
    Route::post('/loan-payments/{loan}', [LoanPaymentController::class, 'store'])->name('loan-payments.store');
    Route::get('/loan-payments/resubmit/{payment}', [LoanPaymentController::class, 'resubmit'])->name('loan-payments.resubmit');

    // Riwayat Pinjaman & Simpanan Routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/riwayat-pinjaman', [RiwayatPinjamanController::class, 'index'])->name('riwayat-pinjaman.index');
        Route::get('/riwayat-simpanan', [RiwayatSimpananController::class, 'index'])->name('riwayat-simpanan.index');
    });

    // Profile routes
    Route::get('/dashboard/profile', [UserDashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [UserDashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
});

// Admin routes - requires admin role
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Profit Report Routes
    Route::get('/profit-report', [ProfitReportController::class, 'index'])->name('profit-report.index');
    Route::get('/profit-report/chart', [ProfitReportController::class, 'getChartData'])->name('profit-report.chart');

    // Loan Approval Routes
    Route::get('/loan-approval', [LoanApplicationController::class, 'index'])->name('loanApproval');
    Route::post('/loan-approval/{loanApplication}/approve', [LoanApplicationController::class, 'approve'])->name('loanApproval.approve');
    Route::post('/loan-approval/{loanApplication}/reject', [LoanApplicationController::class, 'reject'])->name('loanApproval.reject');

    // User management
    Route::get('/users', [UserController::class, 'listUsers'])->name('admin.users');
    Route::post('/users/{id}/remind', [UserController::class, 'remindUser'])->name('admin.users.remind');

    // Loan Payment Routes - Admin side
    Route::get('/payments', [LoanPaymentController::class, 'adminVerification'])->name('admin.payment-verification');
    Route::get('/payments/{payment}', [LoanPaymentController::class, 'getPaymentDetails']);
    Route::post('/payments/{payment}/verify', [\App\Http\Controllers\LoanPaymentController::class, 'verify'])
        ->name('admin.payment.verify');
    Route::post('/payments/{payment}/reject', [\App\Http\Controllers\LoanPaymentController::class, 'reject'])
        ->name('admin.payment.reject');

    // SHU Routes - Admin only
    Route::get('/shu', [ShuController::class, 'index'])->name('admin.shu.index');
    Route::get('/shu/generate', [ShuController::class, 'showGenerateForm'])->name('admin.shu.form');
    Route::post('/shu/generate', [ShuController::class, 'generate'])->name('admin.shu.generate');
    Route::post('/shu/generate-pdf', [ShuController::class, 'generatePDF'])->name('admin.shu.generatePDF');

    // Acceptance routes
    Route::get('/acceptance', [AcceptanceController::class, 'index'])->name('acceptance.index');
    Route::get('/acceptance/approve/{id}', [AcceptanceController::class, 'approve'])->name('acceptance.approve');
    Route::get('/acceptance/reject/{id}', [AcceptanceController::class, 'reject'])->name('acceptance.reject');
});

// Dashboard routes (khusus fitur simpanan, transaksi, dsb)
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function() {
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/simpanan', [DashboardController::class, 'simpanan'])->name('simpanan');
    Route::get('/simpanan/create', [DashboardController::class, 'createSimpanan'])->name('simpanan.create');
    Route::post('/simpanan', [DashboardController::class, 'storeSimpanan'])->name('simpanan.store');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');

    // Routes untuk setoran
    Route::resource('setoran', AdminSetoranController::class);
  
    Route::get('/shu', [DashboardController::class, 'shu'])->name('shu');
    Route::get('/shu/download-pdf/{tahun}', [DashboardController::class, 'downloadShuPdf'])->name('shu.download_pdf');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
Route::get('/dashboard/simpanan', [DashboardController::class, 'simpanan'])->name('dashboard.simpanan');
Route::get('/dashboard/simpanan/create', [DashboardController::class, 'createSimpanan'])->name('dashboard.simpanan.create');
Route::post('/dashboard/simpanan', [DashboardController::class, 'storeSimpanan'])->name('dashboard.simpanan.store');
Route::get('/dashboard/transactions', [DashboardController::class, 'transactions'])->name('dashboard.transactions');

// Discussion routes
Route::get('/discussion', [DiscussionController::class, 'index'])->name('discussion.index');
Route::post('/discussion', [DiscussionController::class, 'store'])->name('discussion.store');
Route::get('/discussion/{discussion}/edit', [DiscussionController::class, 'edit'])->name('discussion.edit');
Route::put('/discussion/{discussion}', [DiscussionController::class, 'update'])->name('discussion.update');
Route::delete('/discussion/{discussion}', [DiscussionController::class, 'destroy'])->name('discussion.destroy');
Route::post('/discussion/{discussion}/comment', [DiscussionCommentController::class, 'store'])->name('discussion.comment.store');

// Notification route (hanya satu)
Route::get('/notifications', [UserController::class, 'showNotifications'])->name('notifications');

// General payment form (jika masih dipakai)
Route::get('/general', function () {
    return view('payment-form');
})->name('payment-form');

// Admin loan application view (jika masih dipakai)
Route::get('/admin-loan-applications', function () {
    return view('admin-loan-application');
});