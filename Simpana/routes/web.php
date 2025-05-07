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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SimpananController;
use App\Models\Notification;

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

     Route::get('/admin/users', [UserController::class, 'listUsers'])->name('admin.users');
     Route::post('/admin/users/{id}/remind', [UserController::class, 'remindUser'])->name('admin.users.remind');
 });


 Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
 Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
 Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
 Route::get('/dashboard/simpanan', [DashboardController::class, 'simpanan'])->name('dashboard.simpanan');
 Route::get('/dashboard/simpanan/create', [DashboardController::class, 'createSimpanan'])->name('dashboard.simpanan.create');
 Route::post('/dashboard/simpanan', [DashboardController::class, 'storeSimpanan'])->name('dashboard.simpanan.store');
 Route::get('/dashboard/transactions', [DashboardController::class, 'transactions'])->name('dashboard.transactions');

 Route::get('/discussion', [DiscussionController::class, 'index'])->name('discussion.index');
 Route::post('/discussion', [DiscussionController::class, 'store'])->name('discussion.store');
 Route::get('/discussion/{discussion}/edit', [DiscussionController::class, 'edit'])->name('discussion.edit');
 Route::put('/discussion/{discussion}', [DiscussionController::class, 'update'])->name('discussion.update');
 Route::delete('/discussion/{discussion}', [DiscussionController::class, 'destroy'])->name('discussion.destroy');
 Route::post('/discussion/{discussion}/comment', [DiscussionCommentController::class, 'store'])->name('discussion.comment.store');

 
Route::get('/admin-loan-applications', function () {
    return view('admin-loan-application');
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

// Add these routes for the simpanan functionality
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function() {
    Route::get('/simpanan', [SimpananController::class, 'index'])->name('simpanan');
    Route::get('/simpanan/create', [SimpananController::class, 'create'])->name('simpanan.create');
    Route::post('/simpanan', [SimpananController::class, 'store'])->name('simpanan.store');
});
