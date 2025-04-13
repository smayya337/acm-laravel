<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureUserIsAdmin;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/events', function () {
    return view('events');
})->name('events');

Route::get('/icpc', function () {
    return view('icpc');
})->name('icpc');

Route::get('/hspc', function () {
    return view('hspc');
})->name('hspc');

Route::get('/donate', function () {
    return view('donate');
})->name('donate');

Route::get('/user/{username}', function (string $username) {
    return view('user_page', ['username' => $username]);
})->name('user_page');

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
