<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegisterForgetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::put('/change-pass', [AuthController::class, 'changePassWord']);    
});

Route::prefix('/members')->group( function() {
    Route::get('/edit/{id}',[MemberController::class,'show'])->name('edit');
    Route::post('/update/{id}',[MemberController::class,'update'])->name('update');

    Route::get('/register-forget',[RegisterForgetController::class,'create'])->name('add');
    Route::post('/register-forget',[RegisterForgetController::class,'store'])->name('create');
});

// Route::apiResource('members', MemberController::class);
