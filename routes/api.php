<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegisterOTController;
use App\Http\Controllers\RegisterForgetController;
use App\Http\Controllers\RegisterLeaveController;
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

Route::prefix('/members')->group(function () {
    Route::get('/edit/{id}', [MemberController::class, 'show'])->name('members.edit');
    Route::put('/update/{id}', [MemberController::class, 'update'])->name('members.update');

    Route::get('/register-forget/{id}',[RegisterForgetController::class,'viewForget'])->name('forget.view');
    Route::post('/register-forget/{id}',[RegisterForgetController::class,'createForget'])->name('forget.create');
    Route::put('/register-forget/edit/{id}',[RegisterForgetController::class,'updateForget'])->name('forget.update');

    Route::get('/register-leave/{id}',[RegisterLeaveController::class,'viewLeave'])->name('leave.view');
    Route::post('/register-leave/{id}',[RegisterLeaveController::class,'createLeave'])->name('leave.create');
    Route::put('/register-leave/edit/{id}',[RegisterLeaveController::class,'updateLeave'])->name('leave.update');

    Route::get('/register-ot/{id}', [RegisterOTController::class, 'viewRegisterOT'])->name('register-ot.view');
    Route::post('/register-ot/{id}', [RegisterOTController::class, 'createRegisterOT'])->name('register-ot.create');
    Route::put('/register-ot/edit/{id}', [RegisterOTController::class, 'updateRegisterOT'])->name('register-ot.update');
});





// Route::apiResource('members', MemberController::class);
