<?php

use App\Http\Controllers\WasteTypesController;
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


// Waste Type routes
Route::controller(WasteTypesController::class)->group(function () {
    Route::get('/waste-types', 'index')->name('waste_types.index');
    Route::post('/waste-types', 'store')->name('waste_types.store');
    Route::put('/waste-types/{wasteType}', 'update')->name('waste_types.update');
    Route::delete('/waste-types/{wasteType}', 'destroy')->name('waste_types.destroy');
    Route::post('/waste-types/{wasteType}/restore', 'restore')->name('waste_types.restore');
    Route::delete('/waste-types/{wasteType}/force-delete', 'forceDelete')->name('waste_types.forceDelete');
});

// Waste management routes
Route::controller(WasteController::class)->group(function () {
    Route::get('/wastes', 'index')->name('wastes.index');
    Route::post('/wastes', 'store')->name('wastes.store');
    Route::put('/wastes/{waste}', 'update')->name('wastes.update');
    Route::delete('/wastes/{waste}', 'destroy')->name('wastes.destroy');
    Route::post('/wastes/{waste}/restore', 'restore')->name('wastes.restore');
    Route::delete('/wastes/{waste}/force-delete', 'forceDelete')->name('wastes.forceDelete');
});




// Resource controllers
Route::resources([
    'roles' => RoleController::class,
    'wastes' => WasteController::class,
    'collections' => CollectionController::class,
    'disposals' => DisposalController::class,
    'reports' => ReportController::class,
]);
