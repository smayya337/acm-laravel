<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\OfficerController;
use App\Http\Controllers\Api\V1\BadgeController;
use App\Http\Controllers\Api\V1\StatsController;
use App\Http\Middleware\EnsureUserIsAdmin;

/*
|--------------------------------------------------------------------------
| API Routes - Version 1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // ========================================
    // Authentication Routes (Public)
    // ========================================
    Route::post('/auth/login', [AuthController::class, 'login'])
        ->middleware('throttle:api:login');

    // Authentication Routes (Authenticated)
    Route::middleware(['auth:sanctum', 'throttle:api:authenticated'])->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::put('/auth/me', [AuthController::class, 'updateProfile']);
        Route::post('/auth/me/avatar', [AuthController::class, 'uploadAvatar']);
    });

    // ========================================
    // User Routes
    // ========================================

    // Public user routes
    Route::get('/users/username/{username}', [UserController::class, 'showByUsername']);
    Route::get('/users/{id}/badges', [UserController::class, 'badges']);

    // Authenticated user routes
    Route::middleware(['auth:sanctum', 'throttle:api:authenticated'])->group(function () {
        Route::get('/users/{id}/events', [UserController::class, 'events']);
    });

    // Admin user routes
    Route::middleware(['auth:sanctum', EnsureUserIsAdmin::class, 'throttle:api:admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::post('/users/{id}/badges', [UserController::class, 'assignBadges']);
        Route::delete('/users/{id}/badges', [UserController::class, 'removeBadges']);
        Route::post('/users/{id}/password', [UserController::class, 'resetPassword']);
    });

    // ========================================
    // Event Routes
    // ========================================

    // Public event routes
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/upcoming', [EventController::class, 'upcoming']);
    Route::get('/events/past', [EventController::class, 'past']);
    Route::get('/events/{id}', [EventController::class, 'show']);

    // Authenticated event routes
    Route::middleware(['auth:sanctum', 'throttle:api:authenticated'])->group(function () {
        Route::get('/events/{id}/attendees', [EventController::class, 'attendees']);
        Route::post('/events/{id}/rsvp', [EventController::class, 'rsvp']);
        Route::delete('/events/{id}/rsvp', [EventController::class, 'cancelRsvp']);
    });

    // Admin event routes
    Route::middleware(['auth:sanctum', EnsureUserIsAdmin::class, 'throttle:api:admin'])->group(function () {
        Route::post('/events', [EventController::class, 'store']);
        Route::put('/events/{id}', [EventController::class, 'update']);
        Route::delete('/events/{id}', [EventController::class, 'destroy']);
        Route::post('/events/{id}/image', [EventController::class, 'uploadImage']);
    });

    // ========================================
    // Officer Routes
    // ========================================

    // Public officer routes
    Route::get('/officers', [OfficerController::class, 'index']);
    Route::get('/officers/current', [OfficerController::class, 'current']);
    Route::get('/officers/year/{year}', [OfficerController::class, 'byYear']);
    Route::get('/officers/{id}', [OfficerController::class, 'show']);

    // Admin officer routes
    Route::middleware(['auth:sanctum', EnsureUserIsAdmin::class, 'throttle:api:admin'])->group(function () {
        Route::post('/officers', [OfficerController::class, 'store']);
        Route::put('/officers/{id}', [OfficerController::class, 'update']);
        Route::delete('/officers/{id}', [OfficerController::class, 'destroy']);
        Route::delete('/officers/year/{year}', [OfficerController::class, 'deleteByYear']);
    });

    // ========================================
    // Badge Routes
    // ========================================

    // Public badge routes
    Route::get('/badges', [BadgeController::class, 'index']);
    Route::get('/badges/{id}', [BadgeController::class, 'show']);

    // Admin badge routes
    Route::middleware(['auth:sanctum', EnsureUserIsAdmin::class, 'throttle:api:admin'])->group(function () {
        Route::post('/badges', [BadgeController::class, 'store']);
        Route::put('/badges/{id}', [BadgeController::class, 'update']);
        Route::delete('/badges/{id}', [BadgeController::class, 'destroy']);
        Route::get('/badges/{id}/users', [BadgeController::class, 'users']);
    });

    // ========================================
    // Statistics Routes
    // ========================================

    // Public stats
    Route::get('/stats/public', [StatsController::class, 'public']);

    // Admin stats
    Route::middleware(['auth:sanctum', EnsureUserIsAdmin::class, 'throttle:api:admin'])->group(function () {
        Route::get('/stats', [StatsController::class, 'index']);
    });
});

/*
|--------------------------------------------------------------------------
| Legacy API Routes (for backwards compatibility)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin API routes (legacy)
Route::middleware(['auth:sanctum', EnsureUserIsAdmin::class])->prefix('admin')->group(function () {
    // Users API
    Route::get('/users', [AdminController::class, 'apiGetUsers']);
    Route::post('/users', [AdminController::class, 'apiCreateUser']);

    // Officers API
    Route::get('/officers', [AdminController::class, 'apiGetOfficers']);
    Route::post('/officers', [AdminController::class, 'apiCreateOfficer']);
    Route::delete('/officers', [AdminController::class, 'apiDeleteAllOfficers']);
});
