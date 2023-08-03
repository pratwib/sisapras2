<?php

use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/', [HomeController::class, 'show'])->name('home');
    Route::get('/sop-peminjaman', [HomeController::class, 'downloadSOP'])->name('home.sop');


    // Route::redirect('/', '/home');

    // Login routes
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register routes
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    // Forgot password routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgot'])->name('forgot');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'email'])->name('forgot.post');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('reset.post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        if (Auth::user()->role == 'user') {
            return redirect('/user/dashboard');
        } elseif (Auth::user()->role == 'admin') {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/superadmin/dashboard');
        }
    });

    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('superadmin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'show'])->middleware('UserAccess:superadmin')->name('dashboard');

        Route::get('/profile', [UserController::class, 'showProfile'])->middleware('UserAccess:superadmin')->name('profile.superadmin');
        Route::post('/profile/{id}/edit', [UserController::class, 'updateProfile'])->middleware('UserAccess:superadmin')->name('profile.edit.superadmin');

        Route::get('/location', [LocationController::class, 'show'])->middleware('UserAccess:superadmin')->name('location');
        Route::post('/location/add', [LocationController::class, 'create'])->middleware('UserAccess:superadmin')->name('location.add');
        Route::post('/location/{id}/edit', [LocationController::class, 'update'])->middleware('UserAccess:superadmin')->name('location.edit');
        Route::delete('/location/{id}/delete', [LocationController::class, 'delete'])->middleware('UserAccess:superadmin')->name('location.delete');
        Route::get('/location/{id}/restore', [LocationController::class, 'restore'])->middleware('UserAccess:superadmin')->name('location.restore');

        Route::get('/admin', [UserController::class, 'showAdmin'])->middleware('UserAccess:superadmin')->name('admin');
        Route::post('/admin/add', [UserController::class, 'createAdmin'])->middleware('UserAccess:superadmin')->name('admin.add');
        Route::post('/admin/{id}/edit', [UserController::class, 'updateAdmin'])->middleware('UserAccess:superadmin')->name('admin.edit');
        Route::delete('/admin/{id}/delete', [UserController::class, 'deleteAdmin'])->middleware('UserAccess:superadmin')->name('admin.delete');
        Route::get('/admin/{id}/restore', [UserController::class, 'restoreAdmin'])->middleware('UserAccess:superadmin')->name('admin.restore');

        Route::get('/item', [ItemController::class, 'showAll'])->middleware('UserAccess:superadmin')->name('item.superadmin');

        Route::get('/borrow', [BorrowController::class, 'show'])->middleware('UserAccess:superadmin')->name('borrow.superadmin');
        Route::get('/borrow/{id}/detail', [BorrowController::class, 'show'])->middleware('UserAccess:superadmin')->name('borrow.detail.superadmin');
        Route::post('/borrow/{id}/approve', [BorrowController::class, 'approved'])->middleware('UserAccess:superadmin')->name('borrow.approve.superadmin');
        Route::post('/borrow/{id}/decline', [BorrowController::class, 'declined'])->middleware('UserAccess:superadmin')->name('borrow.decline.superadmin');
        Route::post('/borrow/{id}/borrow', [BorrowController::class, 'borrowed'])->middleware('UserAccess:superadmin')->name('borrow.borrow.superadmin');
        Route::post('/borrow/{id}/return', [BorrowController::class, 'returned'])->middleware('UserAccess:superadmin')->name('borrow.return.superadmin');

        Route::get('/history', [BorrowController::class, 'history'])->middleware('UserAccess:superadmin')->name('history.superadmin');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'show'])->middleware('UserAccess:admin')->name('dashboard');

        Route::get('/profile', [UserController::class, 'showProfile'])->middleware('UserAccess:admin')->name('profile.admin');
        Route::post('/profile/{id}/edit', [UserController::class, 'updateProfile'])->middleware('UserAccess:admin')->name('profile.edit.admin');

        Route::get('/item', [ItemController::class, 'showByLocation'])->middleware('UserAccess:admin')->name('item.admin');
        Route::post('/item/add', [ItemController::class, 'create'])->middleware('UserAccess:admin')->name('item.add.admin');
        Route::post('/item/{id}/edit', [ItemController::class, 'update'])->middleware('UserAccess:admin')->name('item.edit.admin');
        Route::delete('/item/{id}/delete', [ItemController::class, 'delete'])->middleware('UserAccess:admin')->name('item.delete.admin');
        Route::get('/item/{id}/restore', [ItemController::class, 'restore'])->middleware('UserAccess:admin')->name('item.restore.admin');

        Route::get('/borrow', [BorrowController::class, 'show'])->middleware('UserAccess:admin')->name('borrow.admin');
        Route::get('/borrow/{id}/detail', [BorrowController::class, 'show'])->middleware('UserAccess:admin')->name('borrow.detail.admin');
        Route::post('/borrow/{id}/approve', [BorrowController::class, 'approved'])->middleware('UserAccess:admin')->name('borrow.approve.admin');
        Route::post('/borrow/{id}/decline', [BorrowController::class, 'declined'])->middleware('UserAccess:admin')->name('borrow.decline.admin');
        Route::post('/borrow/{id}/borrow', [BorrowController::class, 'borrowed'])->middleware('UserAccess:admin')->name('borrow.borrow.admin');
        Route::post('/borrow/{id}/return', [BorrowController::class, 'returned'])->middleware('UserAccess:admin')->name('borrow.return.admin');

        Route::get('/history', [BorrowController::class, 'history'])->middleware('UserAccess:admin')->name('history.admin');
    });

    Route::prefix('user')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'show'])->middleware('UserAccess:user')->name('dashboard');

        Route::get('/profile', [UserController::class, 'showProfile'])->middleware('UserAccess:user')->name('profile.user');
        Route::post('/profile/{id}/edit', [UserController::class, 'updateProfile'])->middleware('UserAccess:user')->name('profile.edit.user');

        Route::get('/item', [ItemController::class, 'showAll'])->middleware('UserAccess:user')->name('item.user');
        Route::post('/item/{id}/borrow', [BorrowController::class, 'borrow'])->middleware('UserAccess:user')->name('item.borrow');

        Route::get('/borrow', [BorrowController::class, 'show'])->middleware('UserAccess:user')->name('borrow.user');
        Route::get('/borrow/{id}/detail', [BorrowController::class, 'show'])->middleware('UserAccess:user')->name('borrow.detail.user');
        Route::post('/borrow/{id}/cancel', [BorrowController::class, 'canceled'])->middleware('UserAccess:user')->name('borrow.cancel.user');

        Route::get('/history', [BorrowController::class, 'history'])->middleware('UserAccess:user')->name('history.user');
    });
});
