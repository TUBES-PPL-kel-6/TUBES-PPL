<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\simpPokokController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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

// User routes - requires authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
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
     Route::get('/loan/{loanApplication}/download-approval-letter', [LoanApplicationController::class, 'downloadApprovalLetter'])->name('loan.downloadApprovalLetter');
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
Route::get('/notifications/simpanan', function () {
    return view('notifications', ['type' => 'simpanan']);
})->name('notifications.simpanan');

Route::get('/notifications', [UserController::class, 'showNotifications'])->name('notifications');

// Notification routes
Route::get('/notifications/simpanan', function () {
    return view('notifications', ['type' => 'simpanan']);
})->name('notifications.simpanan');

Route::get('/notifications/pinjaman', function () {
    return view('notifications', ['type' => 'pinjaman']);
})->name('notifications.pinjaman');

Route::get('/notifications/general', [UserController::class, 'showGeneralNotifications'])->name('notifications.general');
Route::get('/notifications/pinjaman', function () {
    return view('notifications', ['type' => 'pinjaman']);
})->name('notifications.pinjaman');

route::get ('/general', function () {
    return view('payment-form');
})->name('payment-form');
