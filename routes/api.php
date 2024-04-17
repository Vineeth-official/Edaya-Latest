<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\callController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth'], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::post('/login', [RegisteredUserController::class, 'login']);
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('user.store');
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('/logout', [RegisteredUserController::class, 'logout']);
        Route::get('/user', [RegisteredUserController::class, 'user']);
        Route::get('/call', [CallController::class, 'index'])->name('call');
        Route::get('/call/{userID}/edit', [CallController::class, 'edit'])->name('call.edit');
        Route::delete('/call/{userID}', [CallController::class, 'destroy'])->name('call-delete');
        Route::post('/callStore', [CallController::class, 'store'])->name('callStore');
      });
    
  

});
