<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Code\CodeController;
use App\Http\Controllers\API\Employee\SmsKimlikController;
use App\Http\Controllers\API\Employee\SmsKimlikSipController;
use App\Http\Controllers\API\Employee\SmsKimlikUnitController;
use App\Http\Controllers\API\Log\LogController;
use App\Http\Controllers\API\QuestionAnswer\SoruCevapController;
use App\Http\Controllers\API\QuestionAnswer\SoruCevapKategoriController;
use App\Http\Controllers\API\Reason\SebepIsteneceklerController;
use App\Http\Controllers\API\Reason\SebeplerController;
use App\Http\Controllers\API\Sms\SmsController;
use App\Http\Controllers\API\Token\DocSignature;
use App\Http\Controllers\API\WebUser\WebUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth_with_token'], function () {
    // Auth
    Route::post('login_verification', [AuthController::class, 'loginVerification']);
    Route::post('change_password', [AuthController::class, 'changePassword']);
    Route::post('new_password', [AuthController::class, 'newPassword']);

    // Token
    Route::get('get_signature_token', [DocSignature::class, 'getSignatureToken']);

    // Logs
    Route::get('logs', [LogController::class, 'index']);
    Route::post('update_sebep_log', [LogController::class, 'updateSebepLog']);

    // Reason
    Route::get('sebepler', [SebeplerController::class, 'index']);
    Route::get('sebep_istenecekler', [SebepIsteneceklerController::class, 'index']);

    // Employee
    Route::prefix('employee')->group(function () {
        Route::get('/', [SmsKimlikController::class, 'index']);
        Route::post('/', [SmsKimlikController::class, 'store']);
        Route::get('/basic', [SmsKimlikController::class, 'basic']);
        Route::get('/log', [SmsKimlikController::class, 'log']);
        Route::put('/change_password/{id}', [SmsKimlikController::class, 'changePassword']);

        // Employee Sip
        Route::prefix('/sip')->group(function () {
            Route::get('/', [SmsKimlikSipController::class, 'index']);
            Route::post('/', [SmsKimlikSipController::class, 'store']);
            Route::delete('/{id}', [SmsKimlikSipController::class, 'destroy']);
        });

        // Employee Unit
        Route::prefix('/unit')->group(function () {
            Route::get('/', [SmsKimlikUnitController::class, 'index']);
        });

        Route::get('/{id}', [SmsKimlikController::class, 'show']);
        Route::put('/{id}', [SmsKimlikController::class, 'update']);
        Route::delete('/{id}', [SmsKimlikController::class, 'destroy']);

    });

    // Question-Answer
    Route::prefix('question_answer')->group(function () {
        Route::get('/', [SoruCevapController::class, 'index']);
        Route::post('/', [SoruCevapController::class, 'store']);
        Route::put('/{id}', [SoruCevapController::class, 'update']);
        Route::delete('/{id}', [SoruCevapController::class, 'destroy']);

        // Question-Answer Category
        Route::prefix('/category')->group(function () {
            Route::get('/', [SoruCevapKategoriController::class, 'index']);
            Route::post('/', [SoruCevapKategoriController::class, 'store']);
            Route::put('/{id}', [SoruCevapKategoriController::class, 'update']);
            Route::delete('/{id}', [SoruCevapKategoriController::class, 'destroy']);
        });
    });

    // Customer
    Route::prefix('web_user')->group(function () {
        Route::get('/', [WebUserController::class, 'index']);
        Route::get('/{id}', [WebUserController::class, 'show']);
    });
});

// Sms Code
Route::get('sms_code', [SmsController::class, 'smsCode']);
Route::post('sms_verification', [SmsController::class, 'smsVerification']);

Route::get('security_code', [CodeController::class, 'securityCode']);

Route::post('forgot_password', [AuthController::class, 'forgotPassword']);

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
