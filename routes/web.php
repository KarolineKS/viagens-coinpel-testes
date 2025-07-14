<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ChangePasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::middleware(['auth', 'user.not.blocked'])->group(function () {
    Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('change-password');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login')->with('info', 'Você foi deslogado com sucesso.');
    })->name('logout');
});


Route::middleware(['auth', 'user.not.blocked', 'password.changed'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('vehicles', VehicleController::class);

    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block');
});
