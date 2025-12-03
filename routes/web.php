<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;




// ===============LOGIN=================
Route::get('/', [AuthController::class, 'loginPage'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===========Change Password============
Route::middleware('auth')->put('/user/password', [UserController::class, 'updatePassword'])->name('user.password.update');


// =========role based route===========
Route::get('/admin/dashboard', function () {
    return view('backend.admin.index');
})->name('admin.dashboard');

Route::get('/clerk/dashboard', function () {
    return view('backend.clerk.index');
})->name('clerk.dashboard');


// =======clerk products=====

Route::middleware(['auth', 'role:clerk'])->group(function () {

    Route::get('/clerk/dashboard', function () {
        return view('backend.clerk.index');
    })->name('clerk.dashboard');

    // IMPORTANT: data route must be ABOVE resource route
    Route::get('products/data', [ProductController::class, 'data'])
        ->name('products.data');

    Route::resource('products', ProductController::class);

    Route::post('products/{product}/adjust-stock', [ProductController::class, 'adjustStock'])
        ->name('products.adjust_stock');
});


// ===========admin page routes==========
Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('backend.admin.index');
    })->name('admin.dashboard');

    Route::get('/admin/low-stock', [AdminController::class, 'lowStock'])
        ->name('admin.lowstock');

    // user management
    Route::resource('users', \App\Http\Controllers\UserManagementController::class);
    
});


