<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegisterOTController;
use App\Http\Controllers\RegisterForgetController;
use App\Http\Controllers\RegisterLeaveController;
use App\Http\Controllers\RegisterLateEarlyController;
use App\Http\Controllers\WorkSheetController;
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
    Route::put('/change-pass', [AuthController::class, 'changePassword']);
});

Route::prefix('/members')->middleware(['checkAuth'])->group(function () {
    Route::get('/edit', [MemberController::class, 'show'])->name('members.edit');
    Route::put('/update', [MemberController::class, 'update'])->name('members.update');

});

Route::prefix('/home')->middleware(['checkAuth'])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/{id}', [HomeController::class, 'showNotification']);
    Route::get('/download/{file}', [HomeController::class, 'downLoad']);   
    Route::put('/notice/update/{id}', [HomeController::class, 'updateNotice']);
});

Route::prefix('/worksheets')->middleware(['checkAuth'])->group(function () {

    Route::get('/', [WorkSheetController::class, 'indexWorksheet'])->name('worksheet.index');
    Route::get('/{id}/{type}', [WorkSheetController::class, 'getRequest'])->name('worksheet.request');

    Route::post('/register-forget/create', [RegisterForgetController::class, 'createRegisterForget'])->name('register-forget.create');
    Route::put('/register-forget/update', [RegisterForgetController::class, 'updateRegisterForget'])->name('register-forget.update');

    Route::post('/register-late-early/create', [RegisterLateEarlyController::class, 'createRegisterLateEarly'])->name('register-late-early.create');
    Route::put('/register-late-early/update', [RegisterLateEarlyController::class, 'updateRegisterLateEarly'])->name('register-late-early.update');

    Route::post('/register-ot/create', [RegisterOTController::class, 'createRegisterOT'])->name('register-ot.create');
    Route::put('/register-ot/update', [RegisterOTController::class, 'updateRegisterOT'])->name('register-ot.update');

    Route::post('/register-leave/create',[RegisterLeaveController::class,'createLeave'])->name('leave.create');
    Route::put('/register-leave/update',[RegisterLeaveController::class,'updateLeave'])->name('leave.update');

});
