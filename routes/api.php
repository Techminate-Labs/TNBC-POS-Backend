<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Models
use App\Models\User;

//Controllers
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordUpdateController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\ProfileController;

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
// Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

    Route::post('/update-password', [PasswordUpdateController::class,'passwordUpdate'])->name('update.password');

    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

    Route::get('/users', [ProfileController::class, 'index']);
    Route::put('/users/{id}', [ProfileController::class, 'updateUser']);
    Route::delete('/users/{id}', [ProfileController::class, 'deleteUser']);

    Route::get('/userProfile/{id}', [ProfileController::class, 'show']);
    Route::post('/userProfile', [ProfileController::class, 'store']);
    Route::put('/userProfile/{id}', [ProfileController::class, 'update']);
    Route::delete('/userProfile/{id}', [ProfileController::class, 'destroy']);
    Route::put('/profilePhotoupdate/{id}', [ProfileController::class, 'profilePhotoupdate']);
});