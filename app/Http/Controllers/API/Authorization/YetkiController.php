<?php

namespace App\Http\Controllers\API\Authorization;

use App\Helpers\CacheOperation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\CopyAuthorizationRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Authorization\AuthorizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * @return SuccessResource
     * @throws Throwable
     */
    public function refreshAuthorization(Request $request): SuccessResource
    {
        CacheOperation::refreshEmployeeSession($request->bearerToken());

        return new SuccessResource(__('messages.' . self::class . '.REFRESH_AUTHORIZATION'));
    }
}
