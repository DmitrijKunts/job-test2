<?php

use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/token', TokenController::class)->name('login');

Route::get('/users', [UserController::class, 'users']);
Route::get('/users/{id}', [UserController::class, 'user']);

Route::get('/positions', PositionController::class);

Route::middleware('auth:sanctum')->post('/users', [UserController::class, 'store']);
