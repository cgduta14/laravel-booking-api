<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return $request->user();
});
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::post('register', [AuthController::class, 'register']);

Route::get('trip/slug/{slug}', [TripController::class, 'getTripBySlug']);
Route::apiResource('trip', TripController::class);
Route::middleware('auth:sanctum')->apiResource('user', UserController::class);

