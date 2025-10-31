<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/registration', [AuthController::class, 'postRegistration'])->name('register.post');

/*
|--------------------------------------------------------------------------
| Dashboard (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Role & Permission Management
    |--------------------------------------------------------------------------
    */
    Route::get('/permissions', [RolePermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions/update', [RolePermissionController::class, 'update'])->name('permissions.update');
    Route::post('/permissions/add-role', [RoleController::class, 'storeRole'])->name('roles.store');

    /*
    |--------------------------------------------------------------------------
    | User Management (Custom Registration + CRUD)
    |--------------------------------------------------------------------------
    */
    Route::get('/user/register', [UserController::class, 'showRegistrationForm'])->name('userRegister');
    Route::post('/user/register', [UserController::class, 'store'])->name('user.store');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Optional: If you want DataTable API endpoint
    Route::get('/users-data', [UserController::class, 'getUsersData'])->name('users.data');

    /*
    |--------------------------------------------------------------------------
    | Category Management
    |--------------------------------------------------------------------------
    */
    Route::resource('categories', CategoryController::class);
});

/*
|--------------------------------------------------------------------------
| Default Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});
