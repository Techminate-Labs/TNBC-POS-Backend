<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Models
use App\Models\User;

//Controllers
use App\Http\Controllers\Auth\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

});