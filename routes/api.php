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

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ProfileSettingController;
use App\Http\Controllers\User\RoleController;

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
    //Auth
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    // Users
    Route::get('/userList', [UserController::class, 'userList']);
    Route::get('/userGetById/{id}', [UserController::class, 'userGetById']);
    Route::put('/userUpdate/{id}', [UserController::class, 'userUpdate']);
    Route::delete('/userDelete/{id}', [UserController::class, 'userDelete']);
    Route::get('/userProfileView/{id}', [UserController::class, 'userProfileView']);
    // Profile
    Route::post('/userProfile', [ProfileController::class, 'store']);
    Route::put('/userProfile/{id}', [ProfileController::class, 'update']);
    Route::delete('/userProfile/{id}', [ProfileController::class, 'destroy']);
    //Profile Settings
    Route::post('/profilePhotoupdate', [ProfileSettingController::class, 'profilePhotoupdate']);
    Route::post('/update-password', [ProfileSettingController::class,'passwordUpdate'])->name('update.password');
    //Roles
    Route::get('/roles', [RoleController::class, 'list']);
    Route::get('/roles/{id}', [RoleController::class, 'details']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

    
});