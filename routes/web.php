<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth_web.jwt'])->group(function() {
    // Route::get('/', function () {
    //     return view('welcome');
    // });
    // Route::get('/', 'HomeController@home');
    Route::controller(HomeController::class)->group(function() {
        Route::get('/', 'home');
    });
    Route::controller(AttendanceController::class)->group(function() {
        Route::get('/presensi/check-in', 'presensi');
        Route::get('/presensi/riwayat', 'riwayat');
        Route::get('/presensi/riwayat/detail/{id}', 'detail');
    }); 
});
Route::controller(AuthController::class)->group(function() {
    Route::middleware(['auth_web.jwt'])->group(function() {
        Route::get('/login', 'login');
        Route::get('/register', 'register');
    });
    Route::get('/logout', 'actionWebLogout');
});

Route::controller(UserProfileController::class)->group(function() {
    Route::middleware(['auth_web.jwt'])->group(function() {
        Route::get('/edit-profil', 'editProfil');
    });
});

