<?php

use App\Http\Controllers\EventController;
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

Route::get('/user/{user}', [UserController::class, 'show'])->middleware('can:view,user')->name('user_page');

Route::post('/user/{user}', [UserController::class, 'update'])->middleware('can:update,user')->name('user_page.update');

Route::get('/event/{event}', [EventController::class, 'show'])->middleware('can:view,event')->name('event_page');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', EnsureUserIsAdmin::class])->name('admin');
