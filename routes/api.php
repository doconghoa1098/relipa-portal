<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
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
    Route::put('/change-pass/{id}', [AuthController::class, 'changePassword']);    
});

Route::prefix('/members')->group( function() {
    Route::get('/edit/{id}',[MemberController::class,'show'])->name('edit');
    Route::post('/update/{id}',[MemberController::class,'update'])->name('update');
});

// Route::apiResource('members', MemberController::class);
