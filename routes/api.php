<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\CardController;
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

Route::prefix('v1')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'store']);
    
    Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
    
    Route::apiResource('users', UserController::class);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('boards', BoardController::class);

    Route::get('boards/{board}/lists', [ListController::class, 'index']);
    Route::post('boards/{board}/lists', [ListController::class, 'store']);
    Route::put('boards/{board}/lists/{list}', [ListController::class, 'update']);
    Route::delete('boards/{board}/lists/{list}', [ListController::class, 'destroy']);

    Route::get('lists/{list}/cards', [CardController::class, 'index']);
    Route::post('lists/{list}/cards', [CardController::class, 'store']);
    Route::put('lists/{list}/cards/{card}', [CardController::class, 'update']);
    Route::delete('lists/{list}/cards/{card}', [CardController::class, 'destroy']);
});
