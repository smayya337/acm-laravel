<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureUserIsAdmin;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/events', [EventController::class, 'index'])->name('events');

Route::get('/icpc', function () {
    return view('icpc');
})->name('icpc');

Route::get('/hspc', function () {
    return view('hspc');
})->name('hspc');

Route::get('/donate', function () {
    return view('donate');
})->name('donate');

Route::controller(UserController::class)->group(function () {
    Route::get('/user/{user}', 'show')->middleware('can:view,user')->name('user_page');
    Route::post('/user/{user}', 'update')->middleware('can:update,user')->name('user_page.update');
});

Route::get('/event/{event}', [EventController::class, 'show'])->middleware('can:view,event')->name('event_page');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index')->middleware(['auth', EnsureUserIsAdmin::class])->name('admin');
    Route::get('/admin/officers', 'officers')->middleware(['auth', EnsureUserIsAdmin::class])->name('admin.officers');
    Route::get('/admin/search/user', 'searchUsers')->middleware(['auth', EnsureUserIsAdmin::class])->name('admin.search.user');
});

Route::controller(OfficerController::class)->group(function () {
    Route::get('/officers', 'index')->name('officers');
    Route::get('/officers/{year}', 'showByYear')->name('officers.by_year');
    Route::post('/admin/officers', 'store')->middleware(['auth', EnsureUserIsAdmin::class])->name('admin.officers.store');
    Route::get('/admin/officers/{officer}', 'show')->middleware(['auth', EnsureUserIsAdmin::class])->name('admin.officers.show');
    Route::post('/admin/officers/{officer}', 'update')->middleware(['auth', EnsureUserIsAdmin::class])->name('admin.officers.update');
    Route::post('/admin/officers/{officer}/delete', 'destroy')->middleware(['auth', EnsureUserIsAdmin::class])->name('admin.officers.delete');
});
