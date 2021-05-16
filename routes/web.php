<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //profile
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::put('/user/update-profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/user/password', [UserProfileController::class, 'changePassword'])->name('password.update');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'penilaian', 'as' => 'penilaian.'], function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/create', [PenilaianController::class, 'create'])->name('create');
        Route::post('/', [PenilaianController::class, 'store'])->name('store');
        Route::get('/{penilaian}', [PenilaianController::class, 'show'])->name('show');
        Route::get('/{penilaian}/edit', [PenilaianController::class, 'edit'])->name('edit');
        Route::put('/{penilaian}', [PenilaianController::class, 'update'])->name('update');
        Route::delete('/{penilaian}', [PenilaianController::class, 'destroy'])->name('destroy');

        Route::post('/{penilaian}/item', [PenilaianController::class, 'storeItem'])->name('item.store');
        Route::get('/{penilaian}/item/{item}/edit', [PenilaianController::class, 'editItem'])->name('item.edit');
        Route::put('/{penilaian}/item/{item}/', [PenilaianController::class, 'updateItem'])->name('item.update');
        Route::put('/{penilaian}/status/{item}/', [PenilaianController::class, 'updateStatus'])->name('status.update');
        Route::delete('/{penilaian}/item/{item}', [PenilaianController::class, 'destroyItem'])->name('item.destroy');
    });
});
