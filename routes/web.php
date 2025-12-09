<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/login', [LoginController::class, 'loginPage'])->name('loginPage');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:web');

Route::get('/', function () {
    return redirect()->route('login');
});
