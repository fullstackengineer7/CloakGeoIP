<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Game1Controller;
use App\Http\Controllers\SocketController;


Route::get('/{path?}', function () {
    return view('home');
})->where('path', '^(?!api).*?');

Route::group(['prefix' => 'api'], function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('user.login.page');
    Route::post('/login', [AuthController::class, 'login'])->name('user.login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('user.register.page');
    Route::post('/register', [AuthController::class, 'register'])->name('user.register');
    Route::get('home', [HomeController::class, 'index'])->name('home');


        Route::post('/testGameOne',[SocketController::class, 'calculateBid']);
        
    Route::middleware(['auth', 'is-active'])->group(function () {      
        Route::get('/signout', [AuthController::class, 'signout'])->name('user.signout');
        // game1
        Route::post('/sendBidGame1',[Game1Controller::class, 'getBidData']);

        //statistics
        Route::get('/user_game1_statistics',[Game1Controller::class, 'user_game1_statistics'])->name('user.game1_statistics');

    });
});