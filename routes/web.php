<?php

use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FinancialController as AdminFinancialController;
use App\Http\Controllers\Admin\LoanApplicationController as AdminLoanApplicationController;
use App\Http\Controllers\Admin\LoanProductController as AdminLoanProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SecurityController as AdminSecurityController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Agent\ClientController as AgentClientController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\LoanController as AgentLoanController;
use App\Http\Controllers\Agent\ProfileController as AgentProfileController;
use App\Http\Controllers\Agent\RepaymentController as AgentRepaymentController;
use App\Http\Controllers\Agent\ReportController as AgentReportController;
use App\Http\Controllers\Agent\ValidationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\LoanApplicationController as ClientLoanApplicationController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\RepaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('landing'))->name('landing');

// Authentification
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
});

Route::middleware('auth')->group(function () {
    Route::get('two-factor-challenge', [TwoFactorController::class, 'showChallenge'])->name('two-factor.challenge');
    Route::post('two-factor-challenge', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
});

Route::post('logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Espace client
Route::middleware(['auth', 'account.active', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
        Route::resource('loans', ClientLoanApplicationController::class)->middleware('rate.limit.loans')->only(['index', 'create', 'store', 'show']);
        Route::get('repayments', [RepaymentController::class, 'index'])->name('repayments.index');
        Route::get('repayments/{repayment}/receipt', [RepaymentController::class, 'receipt'])->name('repayments.receipt');
        Route::get('repayments/create/{loan}', [RepaymentController::class, 'create'])->name('repayments.create');
        Route::post('repayments/{loan}', [RepaymentController::class, 'store'])->name('repayments.store');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/two-factor', [ProfileController::class, 'toggleTwoFactor'])->name('profile.two-factor');
    });

// Espace agent
Route::middleware(['auth', 'account.active', 'role:agent'])
    ->prefix('agent')
    ->name('agent.')
    ->group(function () {
        Route::get('dashboard', [AgentDashboardController::class, 'index'])->name('dashboard');
        Route::get('validations', [ValidationController::class, 'index'])->name('validations.index');
        Route::get('validations/{loan}', [ValidationController::class, 'show'])->name('validations.show');
        Route::post('validations/{loan}/approve', [ValidationController::class, 'validate'])->name('validations.approve');
        Route::post('validations/{loan}/reject', [ValidationController::class, 'reject'])->name('validations.reject');
        Route::post('validations/{loan}/disburse', [ValidationController::class, 'disburse'])->name('validations.disburse');
        Route::get('clients', [AgentClientController::class, 'index'])->name('clients.index');
        Route::get('clients/{client}', [AgentClientController::class, 'show'])->name('clients.show');
        Route::get('loans', [AgentLoanController::class, 'index'])->name('loans.index');
        Route::get('loans/{loan}', [AgentLoanController::class, 'show'])->name('loans.show');
        Route::get('repayments', [AgentRepaymentController::class, 'index'])->name('repayments.index');
        Route::get('repayments/collect', [AgentRepaymentController::class, 'create'])->name('repayments.create');
        Route::post('repayments', [AgentRepaymentController::class, 'store'])->name('repayments.store');

        Route::get('reports/daily', [AgentReportController::class, 'daily'])->name('reports.daily');
        Route::get('reports/monthly', [AgentReportController::class, 'monthly'])->name('reports.monthly');

        Route::get('profile', [AgentProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [AgentProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/two-factor', [AgentProfileController::class, 'toggleTwoFactor'])->name('profile.two-factor');
    });

// Espace administrateur
Route::middleware(['auth', 'account.active', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class)->only(['index', 'show', 'destroy']);
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::resource('loans', AdminLoanApplicationController::class)->only(['index', 'show']);

        // Gestion financière
        Route::get('financial', [AdminFinancialController::class, 'index'])->name('financial.index');
        Route::get('financial/disbursements', [AdminFinancialController::class, 'disbursements'])->name('financial.disbursements');
        Route::get('financial/repayments', [AdminFinancialController::class, 'repayments'])->name('financial.repayments');
        Route::get('financial/penalties', [AdminFinancialController::class, 'penalties'])->name('financial.penalties');
        Route::get('financial/revenue', [AdminFinancialController::class, 'revenue'])->name('financial.revenue');

        // Paramètres
        Route::resource('settings/loan-products', AdminLoanProductController::class)->names('settings.loan-products');
        Route::get('settings/system', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::put('settings/system', [AdminSettingController::class, 'update'])->name('settings.update');

        // Rapports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/credits', [ReportController::class, 'credits'])->name('reports.credits');
        Route::get('reports/financial', [ReportController::class, 'financial'])->name('reports.financial');

        // Sécurité
        Route::get('security/activity-logs', [AdminSecurityController::class, 'activityLogs'])->name('security.activity-logs');
        Route::get('security/login-histories', [AdminSecurityController::class, 'loginHistories'])->name('security.login-histories');

        // Mon compte
        Route::get('account/profile', [AdminAccountController::class, 'profile'])->name('account.profile');
        Route::put('account/profile', [AdminAccountController::class, 'updateProfile'])->name('account.update');
        Route::patch('account/two-factor', [AdminAccountController::class, 'toggleTwoFactor'])->name('account.two-factor');
    });
