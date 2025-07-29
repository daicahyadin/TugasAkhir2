<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\TestDriveController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Models\Promo;
use App\Models\Car;
use App\Models\User;

// ========================================
// PUBLIC ROUTES (No authentication required)
// ========================================

// Landing page
Route::get('/', function () {
    $promos = Promo::where('type', 'promo')->where('is_active', true)->where('start_date', '<=', now())->where('end_date', '>=', now())->latest()->take(3)->get();
    $events = Promo::where('type', 'event')->where('is_active', true)->where('start_date', '<=', now())->where('end_date', '>=', now())->latest()->take(3)->get();
    $news = Promo::where('type', 'news')->where('is_active', true)->where('start_date', '<=', now())->where('end_date', '>=', now())->latest()->take(3)->get();
    $cars = Car::where('stock', '>', 0)->latest()->get();
    return view('welcome', compact('promos', 'events', 'news', 'cars'));
})->name('welcome');

// Public car viewing (no login required)
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

// Halaman verifikasi kode setelah registrasi
Route::get('/verify', function () {
    $email = session('email');
    $verification_code = session('verification_code');
    return view('auth.verify', compact('email', 'verification_code'));
})->name('verification.notice');

// Proses verifikasi kode
Route::post('/verify', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'email' => 'required|email',
        'verification_code' => 'required|digits:6',
    ]);
    $user = User::where('email', $request->email)
        ->where('verification_code', $request->verification_code)
        ->first();
    if ($user) {
        $user->is_verified = true;
        $user->verification_code = null;
        $user->save();
        return redirect()->route('login')->with('status', 'Akun Anda berhasil diverifikasi. Silakan login.');
    } else {
        return back()->withErrors(['verification_code' => 'Kode verifikasi salah atau email tidak cocok.']);
    }
})->name('verification.process');

// Halaman sukses pembelian (public, di luar group middleware)
Route::get('/beli/success', function () {
    return view('purchase.success');
})->name('beli.success');

// ========================================
// CUSTOMER ROUTES (Authenticated customers only)
// ========================================

Route::middleware(['auth', 'verified'])->group(function () {
    // Customer Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\ProfileController::class, 'dashboard'])->name('dashboard');

    // Test Drive (requires login)
    Route::get('/testdrive', [TestDriveController::class, 'form'])->name('testdrive.form');
    Route::post('/testdrive', [TestDriveController::class, 'store'])->name('testdrive.store');
    Route::get('/testdrive/success', [TestDriveController::class, 'success'])->name('testdrive.success');

    // Purchase (requires login)
    Route::get('/beli/{car}', [PurchaseController::class, 'form'])->name('beli.form');
    Route::post('/beli', [PurchaseController::class, 'store'])->name('beli.store');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// ADMIN ROUTES (Authenticated admins only)
// ========================================

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Car Management (CRUD)
    Route::resource('cars', CarController::class);
    
    // Promo Management (CRUD)
    Route::resource('promos', PromoController::class);
    
    // Test Drive Management
    Route::get('/testdrives', [TestDriveController::class, 'index'])->name('testdrives.index');
    Route::get('/testdrives/{testDrive}', [TestDriveController::class, 'show'])->name('testdrives.show');
    Route::patch('/testdrives/{testDrive}/status', [TestDriveController::class, 'updateStatus'])->name('testdrives.update-status');
    Route::delete('/testdrives/{testDrive}', [TestDriveController::class, 'destroy'])->name('testdrives.destroy');
    
    // Purchase Management
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::patch('/purchases/{purchase}/status', [PurchaseController::class, 'updateStatus'])->name('purchases.update-status');
    Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/download', [ReportController::class, 'download'])->name('reports.download');
    Route::post('/reports/send-to-superadmin', [ReportController::class, 'sendToSuperAdmin'])->name('reports.send-to-superadmin');
});

// ========================================
// SUPER ADMIN ROUTES (Authenticated super admins only)
// ========================================

Route::middleware(['auth', 'verified', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Super Admin Dashboard
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users.index');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [SuperAdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('users.destroy');
    
    // All Reports (from all admins)
    Route::get('/reports', [ReportController::class, 'superAdminReports'])->name('reports.index');
    Route::get('/reports/download', [ReportController::class, 'superAdminDownload'])->name('reports.download');
    
    // STNK Status Management
    Route::get('/stnk-status', [SuperAdminController::class, 'stnkStatus'])->name('stnk.status');
    Route::patch('/stnk-status/{stnk}/update', [SuperAdminController::class, 'updateStnkStatus'])->name('stnk.update-status');
});

// ========================================
// AUTHENTICATION ROUTES
// ========================================

require __DIR__.'/auth.php';
