<?php

namespace App\Http\Controllers\API\Authorization;

use App\Builder\SmsKimlikBuilder;
use App\Helpers\CacheOperation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\CopyAuthorizationRequest;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\SuccessResource;
use App\Models\SmsKimlik\SmsKimlik;
use App\Services\Authorization\AuthorizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Throwable;

/**
 * Class YetkiController
 *
 * @package App\Http\Controllers\API\Authorization
 */
class YetkiController extends Controller
{
    /**
     * @param CopyAuthorizationRequest  $request
     *
     * @return SuccessResource
     * @throws Throwable
     */
    public function copy(CopyAuthorizationRequest $request): SuccessResource
    {
        (new AuthorizationService(Auth::id()))->copyAuthorization($request);

        return new SuccessResource(__('messages.' . self::class . '.COPY'));
    }

    /**
     * @param Request  $request
     *
     * @return EmployeeResource
     * @throws Throwable
     */
    public function refreshAuthorization(Request $request): EmployeeResource
    {
        $token = $request->bearerToken();
        CacheOperation::refreshEmployeeSession($request->bearerToken());
        $smsKimlik = SmsKimlikBuilder::handle(new SmsKimlik(Cache::get("sms_kimlik_$token")), $token);

        return new EmployeeResource($smsKimlik, __('messages.' . self::class . '.REFRESH_AUTHORIZATION'));
    }
}
