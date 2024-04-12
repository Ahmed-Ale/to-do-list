<?php

use App\Helpers\ApiResponse;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToDosController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::controller(ToDosController::class)->group(function () {
        Route::get('/todos', 'index');
        Route::post('/todos', 'store');
        Route::get('/todos/{id}', 'single');
        Route::post('/todos/update/{id}', 'update');
        Route::post('/todos/completed/{id}', 'completed');
        Route::delete('/todos/{id}', 'destroy');
    });
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware(["auth:sanctum"]);
