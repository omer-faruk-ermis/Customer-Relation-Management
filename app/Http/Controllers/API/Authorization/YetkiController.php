<?php

namespace App\Http\Controllers\API\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\CopyAuthorizationRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Authorization\AuthorizationService;
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

        return new SuccessResource('AUTHORIZATION.COPY.SUCCESS');
    }
}
