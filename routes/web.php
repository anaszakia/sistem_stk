<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\Auth\LoginController;


// hanya bisa diakses tamu (belum login)
Route::middleware('guest')->group(function () {
    // Form login
    Route::get('/login', [LoginController::class, 'showLoginForm'])
         ->name('login');

    // Proses login
    Route::post('/login', [LoginController::class, 'login'])
         ->middleware('log.sensitive')
         ->name('login.submit');

    // Form register
    Route::get('/register', [LoginController::class, 'showRegisterForm'])
         ->name('register');

    // Proses register
    Route::post('/register', [LoginController::class, 'register'])
         ->middleware('log.sensitive')
         ->name('register.submit');
});

// Logout (method POST demi keamanan; pakai @csrf di form logout)
Route::post('/logout', [LoginController::class, 'logout'])
     ->middleware(['auth', 'log.sensitive'])
     ->name('logout');



// Authenticated routes - Permission based access control
Route::middleware(['auth', 'log.sensitive'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:edit profile')
        ->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:edit profile')
        ->name('profile.update');
    
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');
    
    // User management routes
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:view users')
        ->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])
        ->middleware('permission:create users')
        ->name('users.create');
    Route::post('/users', [UserController::class, 'store'])
        ->middleware('permission:create users')
        ->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])
        ->middleware('permission:view users')
        ->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('permission:edit users')
        ->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])
        ->middleware('permission:edit users')
        ->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:delete users')
        ->name('users.destroy');
    
    // Audit Log routes
    Route::get('/audit', [AuditLogController::class, 'index'])
        ->middleware('permission:view audit logs')
        ->name('audit.index');
    Route::get('/audit/{auditLog}', [AuditLogController::class, 'show'])
        ->middleware('permission:view audit logs')
        ->name('audit.show');
    Route::post('/audit/export', [AuditLogController::class, 'export'])
        ->middleware('permission:export audit logs')
        ->name('audit.export');
    
    // Role management routes
    Route::resource('roles', App\Http\Controllers\RoleController::class)
        ->middleware('permission:view roles');
    Route::get('/roles/{role}', [App\Http\Controllers\RoleController::class, 'show'])
        ->middleware('permission:view roles')
        ->name('roles.show');
    Route::get('/roles/{role}/edit', [App\Http\Controllers\RoleController::class, 'edit'])
        ->middleware('permission:edit roles')
        ->name('roles.edit');
    Route::put('/roles/{role}', [App\Http\Controllers\RoleController::class, 'update'])
        ->middleware('permission:edit roles')
        ->name('roles.update');
    Route::delete('/roles/{role}', [App\Http\Controllers\RoleController::class, 'destroy'])
        ->middleware('permission:delete roles')
        ->name('roles.destroy');
    
    // Permission management routes
    Route::resource('permissions', App\Http\Controllers\PermissionController::class)
        ->middleware('permission:view permissions');
    Route::get('/permissions/{permission}', [App\Http\Controllers\PermissionController::class, 'show'])
        ->middleware('permission:view permissions')
        ->name('permissions.show');
    Route::get('/permissions/{permission}/edit', [App\Http\Controllers\PermissionController::class, 'edit'])
        ->middleware('permission:edit permissions')
        ->name('permissions.edit');
    Route::put('/permissions/{permission}', [App\Http\Controllers\PermissionController::class, 'update'])
        ->middleware('permission:edit permissions')
        ->name('permissions.update');
    Route::delete('/permissions/{permission}', [App\Http\Controllers\PermissionController::class, 'destroy'])
        ->middleware('permission:delete permissions')
        ->name('permissions.destroy');
    
    // Kendaraan management routes
    Route::get('/kendaraan', [KendaraanController::class, 'index'])
        ->middleware('permission:view kendaraan')
        ->name('kendaraan.index');
    Route::get('/kendaraan/create', [KendaraanController::class, 'create'])
        ->middleware('permission:create kendaraan')
        ->name('kendaraan.create');
    Route::post('/kendaraan', [KendaraanController::class, 'store'])
        ->middleware('permission:create kendaraan')
        ->name('kendaraan.store');
    Route::get('/kendaraan/{kendaraan}', [KendaraanController::class, 'show'])
        ->middleware('permission:view kendaraan')
        ->name('kendaraan.show');
    Route::get('/kendaraan/{kendaraan}/edit', [KendaraanController::class, 'edit'])
        ->middleware('permission:edit kendaraan')
        ->name('kendaraan.edit');
    Route::put('/kendaraan/{kendaraan}', [KendaraanController::class, 'update'])
        ->middleware('permission:edit kendaraan')
        ->name('kendaraan.update');
    Route::delete('/kendaraan/{kendaraan}', [KendaraanController::class, 'destroy'])
        ->middleware('permission:delete kendaraan')
        ->name('kendaraan.destroy');
    
    // Pemesanan Kendaraan routes
    Route::get('/pemesanan', [PemesananController::class, 'index'])
        ->middleware('permission:view pemesanan')
        ->name('pemesanan.index');
    Route::get('/pemesanan/create', [PemesananController::class, 'create'])
        ->middleware('permission:create pemesanan')
        ->name('pemesanan.create');
    Route::post('/pemesanan', [PemesananController::class, 'store'])
        ->middleware('permission:create pemesanan')
        ->name('pemesanan.store');
    Route::get('/pemesanan/{pemesanan}', [PemesananController::class, 'show'])
        ->middleware('permission:view pemesanan')
        ->name('pemesanan.show');
    Route::get('/pemesanan/{pemesanan}/edit', [PemesananController::class, 'edit'])
        ->middleware('permission:edit pemesanan')
        ->name('pemesanan.edit');
    Route::put('/pemesanan/{pemesanan}', [PemesananController::class, 'update'])
        ->middleware('permission:edit pemesanan')
        ->name('pemesanan.update');
    Route::delete('/pemesanan/{pemesanan}', [PemesananController::class, 'destroy'])
        ->middleware('permission:delete pemesanan')
        ->name('pemesanan.destroy');
    
    // Pemesanan approval routes (Admin Transport only)
    Route::get('/pemesanan/{pemesanan}/approve', [PemesananController::class, 'approveForm'])
        ->middleware('permission:approve pemesanan')
        ->name('pemesanan.approve.form');
    Route::post('/pemesanan/{pemesanan}/approve', [PemesananController::class, 'approve'])
        ->middleware('permission:approve pemesanan')
        ->name('pemesanan.approve');
    Route::post('/pemesanan/{pemesanan}/reject', [PemesananController::class, 'reject'])
        ->middleware('permission:approve pemesanan')
        ->name('pemesanan.reject');
    Route::post('/pemesanan/{pemesanan}/complete', [PemesananController::class, 'complete'])
        ->middleware('permission:approve pemesanan')
        ->name('pemesanan.complete');

    // Surat Jalan routes
    Route::get('/surat-jalan', [App\Http\Controllers\SuratJalanController::class, 'index'])
        ->middleware('permission:view pemesanan')
        ->name('surat-jalan.index');
    Route::get('/surat-jalan/{suratJalan}', [App\Http\Controllers\SuratJalanController::class, 'show'])
        ->middleware('permission:view pemesanan')
        ->name('surat-jalan.show');
    Route::get('/surat-jalan/{suratJalan}/print', [App\Http\Controllers\SuratJalanController::class, 'print'])
        ->middleware('permission:view pemesanan')
        ->name('surat-jalan.print');
    Route::get('/surat-jalan/{suratJalan}/download', [App\Http\Controllers\SuratJalanController::class, 'download'])
        ->middleware('permission:view pemesanan')
        ->name('surat-jalan.download');
    Route::post('/surat-jalan/{suratJalan}/complete', [App\Http\Controllers\SuratJalanController::class, 'complete'])
        ->middleware('permission:approve pemesanan')
        ->name('surat-jalan.complete');
});

Route::redirect('/', '/login');
