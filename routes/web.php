<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\WasteTypeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DisposalController;
use App\Http\Controllers\ReportController;

Route::redirect('/', '/login');

// Authentication routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/password/reset', 'showResetForm')->name('password.request');
    Route::post('/password/email', 'sendResetLinkEmail')->name('password.email');
});

// Public routes
Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');

// User management routes
Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index');
    Route::post('/users', 'store')->name('users.store');
    Route::put('/users/{user}', 'update')->name('users.update');
    Route::delete('/users/{user}', 'destroy')->name('users.destroy');
    Route::get('/users/restore/{id}', 'restore')->name('users.restore');
    Route::delete('/users/force-delete/{id}', 'forceDelete')->name('users.forceDelete');
});

// Role management routes
Route::controller(RoleController::class)->group(function () {
    Route::get('/roles', 'index')->name('roles.index');
    Route::post('/roles', 'store')->name('roles.store');
    Route::put('/roles/{role}', 'update')->name('roles.update');
    Route::delete('/roles/{role}', 'destroy')->name('roles.destroy');
    Route::post('roles/{id}/restore', [RoleController::class, 'restore'])->name('roles.restore');
    Route::delete('roles/{id}/force-delete', [RoleController::class, 'forceDelete'])->name('roles.forceDelete');
});


// Resource controllers
Route::resources([
    'roles' => RoleController::class,
    'waste-types' => WasteTypeController::class,
    'wastes' => WasteController::class,
    'collections' => CollectionController::class,
    'disposals' => DisposalController::class,
    'reports' => ReportController::class,
]);
