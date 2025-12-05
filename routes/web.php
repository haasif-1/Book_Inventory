<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientCartController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;




// ===============LOGIN=================
Route::get('/', [AuthController::class, 'loginPage'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'registerPage'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

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
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('backend.admin.index');
    })->name('admin.dashboard');

    Route::get('/admin/low-stock', [AdminController::class, 'lowStock'])
        ->name('admin.lowstock');

    Route::get('/admin/products', [AdminController::class, 'productsPage'])
        ->name('admin.products');

    // JSON data for AJAX
    Route::get('/admin/products/data', [AdminController::class, 'productsData']);
    // user management
    Route::resource('users', \App\Http\Controllers\UserManagementController::class);

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders');

    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('admin.orders.show');

    Route::post('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('admin.orders.status');
});


// ===========client page routes==========
// CLIENT DASHBOARD
Route::middleware(['auth', 'role:client'])->group(function () {

    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])
        ->name('client.dashboard');

    // My Orders (EMPTY page)
    Route::get('/client/orders', [ClientController::class, 'orders'])
        ->name('client.orders');

    // Add to cart
    Route::post('/client/cart/add', [ClientCartController::class, 'add'])->name('cart.add');

    // Cart count fetch
    Route::get('/client/cart/count', [ClientCartController::class, 'count'])->name('cart.count');

    // Cart page (optional for now)
    Route::get('/client/cart', [ClientCartController::class, 'view'])->name('cart.view');

    // CART UPDATE (QTY)
    Route::post('/client/cart/update/{cart}', [ClientCartController::class, 'updateQty'])
        ->name('cart.update');

    // CART REMOVE
    Route::delete('/client/cart/remove/{cart}', [ClientCartController::class, 'remove'])
        ->name('cart.remove');

    Route::get('/client/checkout', [CheckoutController::class, 'show'])
        ->name('checkout.show');

    Route::post('/client/checkout', [CheckoutController::class, 'placeOrder'])
        ->name('checkout.place');

    // Orders List
    Route::get('/client/orders', [OrderController::class, 'index'])->name('client.orders');

    // Order Detail
    Route::get('/client/orders/{order}', [OrderController::class, 'show'])->name('client.orders.show');

    // Payment Success Page
    Route::get('/client/payment/success', function () {
        return view('backend.client.payment_success');
    })->name('payment.success');

    Route::post('/client/orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('client.order.cancel');
});


Route::get('/client/orders/{order}/invoice', [OrderController::class, 'invoice'])
    ->name('client.orders.invoice');
