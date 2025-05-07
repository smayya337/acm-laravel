<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureUserIsAdmin;
use \Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/events', function () {
    $events = DB::table('events')->where('start', '>=', now())->orderBy('start')->get();
    return view('events', ['events' => $events]);
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

Route::get('/user/{username}', [UserController::class, 'show'])->name('user_page');

Route::post('/user/{username}', function (string $username) {
    $matches = DB::table('users')->where('username', $username);
    if ($matches->count() == 0) {
        abort(400);
    }
})->name('user_page.update');

Route::get('/event/{id}', function (int $id) {
    $matches = DB::table('events')->where('id', $id);
    if ($matches->count() == 0) {
        abort(404);
    }
    return view('event_page', ['event' => $matches->first()]);
})->name('event_page');

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
