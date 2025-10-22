<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\EnsureUserIsAdmin;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin API routes
Route::middleware(['auth:sanctum', EnsureUserIsAdmin::class])->prefix('admin')->group(function () {
    // Users API
    Route::get('/users', [AdminController::class, 'apiGetUsers']);
    Route::post('/users', [AdminController::class, 'apiCreateUser']);

    // Officers API
    Route::get('/officers', [AdminController::class, 'apiGetOfficers']);
    Route::post('/officers', [AdminController::class, 'apiCreateOfficer']);
    Route::delete('/officers', [AdminController::class, 'apiDeleteAllOfficers']);
});
