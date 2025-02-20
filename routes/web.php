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
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

// Public routes (No authentication required)
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('waste-types', WasteTypeController::class);
Route::resource('wastes', WasteController::class);
Route::resource('collections', CollectionController::class);
Route::resource('disposals', DisposalController::class);
Route::resource('reports', ReportController::class);
