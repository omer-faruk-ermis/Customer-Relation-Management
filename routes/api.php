<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Authorization\SmsKimlikWebUserTipYetkiController;
use App\Http\Controllers\API\Authorization\SmsKimlikYetkiController;
use App\Http\Controllers\API\Authorization\YetkiController;
use App\Http\Controllers\API\Blocked\EngellenenKimlikNoController;
use App\Http\Controllers\API\Blocked\EngellenenMailController;
use App\Http\Controllers\API\Blocked\EngellenenTelNoController;
use App\Http\Controllers\API\Blocked\EngellenenVergiNoController;
use App\Http\Controllers\API\Call\CagriController;
use App\Http\Controllers\API\Code\CodeController;
use App\Http\Controllers\API\Employee\SmsKimlikController;
use App\Http\Controllers\API\Employee\SmsKimlikSipController;
use App\Http\Controllers\API\Employee\SmsKimlikUnitController;
use App\Http\Controllers\API\Enum\EnumController;
use App\Http\Controllers\API\Log\LogController;
use App\Http\Controllers\API\Menu\DetayMenuController;
use App\Http\Controllers\API\Menu\DetayMenuUserController;
use App\Http\Controllers\API\Menu\MenuTanimController;
use App\Http\Controllers\API\Module\ModuleController;
use App\Http\Controllers\API\Operator\OperatorTanimlariController;
use App\Http\Controllers\API\QuestionAnswer\SoruCevapController;
use App\Http\Controllers\API\QuestionAnswer\SoruCevapKategoriController;
use App\Http\Controllers\API\Reason\SebepIsteneceklerController;
use App\Http\Controllers\API\Reason\SebeplerController;
use App\Http\Controllers\API\Sms\SmsController;
use App\Http\Controllers\API\Staff\PersonelGrupController;
use App\Http\Controllers\API\Staff\PersonelGrupEslestirController;
use App\Http\Controllers\API\Staff\PersonelGrupYetkiEslestirController;
use App\Http\Controllers\API\Subject\KonuBilgiController;
use App\Http\Controllers\API\Subject\KonuBilgiKullanimYeriController;
use App\Http\Controllers\API\Subscriber\AboneKutukYetkiController;
use App\Http\Controllers\API\Subscriber\VipOzelMusteriEslestirController;
use App\Http\Controllers\API\Token\DocSignatureController;
use App\Http\Controllers\API\Url\UrlTanimController;
use App\Http\Controllers\API\VoiceUser\VoiceUserController;
use App\Http\Controllers\API\WebPortal\WebPortalYetkiController;
use App\Http\Controllers\API\WebPortal\WebPortalYetkiIzinController;
use App\Http\Controllers\API\WebUser\WebUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth_with_token'], function () {

    // Enums
    Route::get('enum', [EnumController::class, 'index']);

    // Auth
    Route::post('login_verification', [AuthController::class, 'loginVerification']);
    Route::post('change_password', [AuthController::class, 'changePassword']);

    // Token
    Route::get('get_signature_token', [DocSignatureController::class, 'getSignatureToken']);

    // Log
    Route::get('log', [LogController::class, 'index']);
    Route::post('update_reason_log', [LogController::class, 'updateReasonLog']);

    // Reason
    Route::get('reasons', [SebeplerController::class, 'index']);

    Route::prefix('reason')->group(function () {
        Route::get('/', [SebeplerController::class, 'index']);
        Route::post('/', [SebeplerController::class, 'store']);
        Route::put('/{id}', [SebeplerController::class, 'update']);
    });
    Route::get('reason_wanted', [SebepIsteneceklerController::class, 'index']);

    // Operator
    Route::get('operator_define', [OperatorTanimlariController::class, 'index']);

    // Authorization
    Route::prefix('authorization')->group(function () {
        Route::post('/copy', [YetkiController::class, 'copy']);
        Route::get('refresh_authorization', [YetkiController::class, 'refreshAuthorization']);
    });

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

    // Customer // Maybe Not Customer
    Route::prefix('web_user')->group(function () {
        Route::get('/type', [WebUserController::class, 'type']);
        Route::get('/', [WebUserController::class, 'index']);
        Route::get('/{id}', [WebUserController::class, 'show']);
    });

    // Call
    Route::prefix('call')->group(function () {
        Route::get('/', [CagriController::class, 'index']);
    });

    // VoiceUser
    Route::prefix('voice_user')->group(function () {
        Route::post('/', [VoiceUserController::class, 'store']);
        Route::get('/path', [VoiceUserController::class, 'path']);
        Route::get('/last_pair', [VoiceUserController::class, 'lastPair']);
        Route::delete('/{id}', [VoiceUserController::class, 'destroy']);
    });

    // Subject
    Route::prefix('subject')->group(function () {
        Route::get('/', [KonuBilgiController::class, 'index']);
        Route::post('/', [KonuBilgiController::class, 'store']);
        Route::get('/use_place', [KonuBilgiKullanimYeriController::class, 'index']);
        Route::put('/{id}', [KonuBilgiController::class, 'update']);
        Route::delete('/{id}', [KonuBilgiController::class, 'destroy']);
    });

    // Vip Special Customer Match
    Route::prefix('customer_priority')->group(function () {
        Route::get('/', [VipOzelMusteriEslestirController::class, 'index']);
        Route::post('/', [VipOzelMusteriEslestirController::class, 'store']);
        Route::put('/{id}', [VipOzelMusteriEslestirController::class, 'update']);
        Route::delete('/{id}', [VipOzelMusteriEslestirController::class, 'destroy']);
    });

    // Module
    Route::prefix('/module')->group(function () {
        Route::get('/', [ModuleController::class, 'index']);
        Route::post('/', [ModuleController::class, 'store']);
        Route::put('/{id}', [ModuleController::class, 'update']);
        Route::delete('/{id}', [ModuleController::class, 'destroy']);
    });

    // Menu-Url Tanim // SmsManagement type=1
    Route::prefix('sms_management')->group(function () {
        // Menu
        Route::prefix('/menu')->group(function () {
            Route::get('/', [MenuTanimController::class, 'menu']);
            Route::post('/', [MenuTanimController::class, 'store']);
            Route::put('/{id}', [MenuTanimController::class, 'update']);
            Route::delete('/{id}', [MenuTanimController::class, 'destroy']);
        });

        // Page
        Route::prefix('/page')->group(function () {
            Route::get('/', [UrlTanimController::class, 'page']);
            Route::post('/', [UrlTanimController::class, 'store']);
            Route::put('/{id}', [UrlTanimController::class, 'update']);
            Route::delete('/{id}', [UrlTanimController::class, 'destroy']);
        });

        // SmsKimlikYetki
        Route::prefix('/authorization')->group(function () {
            Route::post('/', [SmsKimlikYetkiController::class, 'store']);
            Route::delete('/', [SmsKimlikYetkiController::class, 'destroy']);
            Route::post('/bulk', [SmsKimlikYetkiController::class, 'bulk']);
        });
    });

    // DetailMenu // BlueScreen type=2
    Route::prefix('blue_screen')->group(function () {
        Route::get('/menu', [DetayMenuController::class, 'menu']);
        Route::get('/page', [DetayMenuController::class, 'page']);

        // DetailMenuUser
        Route::prefix('/authorization')->group(function () {
            Route::post('/', [DetayMenuUserController::class, 'store']);
            Route::delete('/', [DetayMenuUserController::class, 'destroy']);
            Route::post('/bulk', [DetayMenuUserController::class, 'bulk']);
        });
    });

    // WebPortalAuthorization // Authorization type=3
    Route::prefix('web_portal_authorization')->group(function () {
        Route::get('/menu', [WebPortalYetkiController::class, 'menu']);
        Route::get('/page', [WebPortalYetkiController::class, 'page']);

        // WebPortalAuthorizationPermission
        Route::prefix('/authorization')->group(function () {
            Route::post('/', [WebPortalYetkiIzinController::class, 'store']);
            Route::delete('/', [WebPortalYetkiIzinController::class, 'destroy']);
            Route::post('/bulk', [WebPortalYetkiIzinController::class, 'bulk']);
        });
    });

    // SubscriberBilletAuthorization // SubscriberBillet type=4
    Route::prefix('subscriber_billet_authorization')->group(function () {
        Route::get('/menu', [AboneKutukYetkiController::class, 'menu']);
        Route::get('/page', [AboneKutukYetkiController::class, 'page']);
    });

    // Employee WebUser Type Authorization
    Route::prefix('/employee_web_user_type_authorization')->group(function () {
        Route::get('/', [SmsKimlikWebUserTipYetkiController::class, 'index']);
        Route::post('/', [SmsKimlikWebUserTipYetkiController::class, 'store']);
        Route::delete('/', [SmsKimlikWebUserTipYetkiController::class, 'destroy']);
        Route::post('/bulk', [SmsKimlikWebUserTipYetkiController::class, 'bulk']);
    });

    // StaffGroup
    Route::prefix('staff_group')->group(function () {
        Route::get('/', [PersonelGrupController::class, 'index']);
        Route::get('/{id}', [PersonelGrupController::class, 'show']);
        Route::post('/', [PersonelGrupController::class, 'store']);
        Route::put('/{id}', [PersonelGrupController::class, 'update']);
        Route::delete('/{id}', [PersonelGrupController::class, 'destroy']);

        // StaffGroup + Staff Match
        Route::prefix('/match')->group(function () {
            // StaffGroup + Authorization Match
            Route::prefix('/authorization')->group(function () {
                Route::post('/', [PersonelGrupYetkiEslestirController::class, 'store']);
                Route::delete('/', [PersonelGrupYetkiEslestirController::class, 'destroy']);
                Route::post('/bulk', [PersonelGrupYetkiEslestirController::class, 'bulk']);
            });

            Route::post('/', [PersonelGrupEslestirController::class, 'store']);
            Route::delete('/', [PersonelGrupEslestirController::class, 'destroy']);
            Route::delete('/{id}', [PersonelGrupEslestirController::class, 'destroyStaff']);
            Route::post('/bulk', [PersonelGrupEslestirController::class, 'bulk']);
        });
    });

    // Blocked
    Route::prefix('/blocked')->group(function () {
        Route::prefix('/identity_no')->group(function () {
            Route::get('/', [EngellenenKimlikNoController::class, 'index']);
            Route::post('/', [EngellenenKimlikNoController::class, 'store']);
            Route::delete('/{id}', [EngellenenKimlikNoController::class, 'destroy']);
        });

        Route::prefix('/email')->group(function () {
            Route::get('/', [EngellenenMailController::class, 'index']);
            Route::post('/', [EngellenenMailController::class, 'store']);
            Route::delete('/{id}', [EngellenenMailController::class, 'destroy']);
        });

        Route::prefix('/phone')->group(function () {
            Route::get('/', [EngellenenTelNoController::class, 'index']);
            Route::post('/', [EngellenenTelNoController::class, 'store']);
            Route::delete('/{id}', [EngellenenTelNoController::class, 'destroy']);
        });

        Route::prefix('/tax_identification_no')->group(function () {
            Route::get('/', [EngellenenVergiNoController::class, 'index']);
            Route::post('/', [EngellenenVergiNoController::class, 'store']);
            Route::delete('/{id}', [EngellenenVergiNoController::class, 'destroy']);
        });
    });
});

// Sms Code
Route::get('sms_code', [SmsController::class, 'smsCode']);
Route::post('sms_verification', [SmsController::class, 'smsVerification']);

Route::get('security_code', [CodeController::class, 'securityCode']);

Route::post('forgot_password', [AuthController::class, 'forgotPassword']);
Route::post('new_password', [AuthController::class, 'newPassword']);

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::get('laravel_logs', [LogViewerController::class, 'index']);
