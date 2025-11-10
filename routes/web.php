<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\TripPackageController;
use App\Http\Controllers\RolePermissionController;

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
| Protected Routes (Require Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Role & Permission Management
    |--------------------------------------------------------------------------
    */
    Route::get('/users-data', [UserController::class, 'getUsersData'])->name('users.data');
    Route::post('/users/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');

    Route::get('/permissions', [RolePermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions/update', [RolePermissionController::class, 'update'])->name('permissions.update');
    Route::post('/permissions/add-role', [RoleController::class, 'storeRole'])->name('roles.store');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');

    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */
    Route::get('/user/register', [UserController::class, 'showRegistrationForm'])->name('userRegister');
    Route::post('/user/register', [UserController::class, 'store'])->name('user.store');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    /*
    |--------------------------------------------------------------------------
    | Category Management
    |--------------------------------------------------------------------------
    */
    Route::resource('categories', CategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | Destination Management
    |--------------------------------------------------------------------------
    */
    Route::resource('destinations', DestinationController::class);

    /*
    |--------------------------------------------------------------------------
    | Trip Package Management
    |--------------------------------------------------------------------------
    */
    Route::resource('trip-packages', TripPackageController::class);
    Route::delete('trip-packages/images/{id}', [TripPackageController::class, 'destroyImage'])
        ->name('trip-packages.images.destroy');
    Route::post('trip-packages/upload-image', [TripPackageController::class, 'uploadImage'])
        ->name('trip-packages.upload.image');

    /*
    |--------------------------------------------------------------------------
    | FAQ Management
    |--------------------------------------------------------------------------
    */
    Route::resource('faqs', FaqsController::class);
});

/*
|--------------------------------------------------------------------------
| Default Route (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});
