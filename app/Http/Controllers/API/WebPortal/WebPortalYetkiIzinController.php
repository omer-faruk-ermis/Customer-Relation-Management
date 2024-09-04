<?php

namespace App\Http\Controllers\API\WebPortal;

use App\Exceptions\ForbiddenException;
use App\Exceptions\WebPortal\WebPortalAuthorizationPermissionNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebPortal\BulkWebPortalAuthorizationPermissionRequest;
use App\Http\Requests\WebPortal\DestroyWebPortalAuthorizationPermissionRequest;
use App\Http\Requests\WebPortal\StoreWebPortalAuthorizationPermissionRequest;
use App\Http\Resources\SuccessResource;
use App\Services\WebPortal\WebPortalAuthorizationPermissionService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class WebPortalYetkiIzinController
 *
 * @package App\Http\Controllers\API\WebPortal
 */
class WebPortalYetkiIzinController extends Controller
{
    /** @var WebPortalAuthorizationPermissionService $webPortalAuthorizationPermissionService */
    private WebPortalAuthorizationPermissionService $webPortalAuthorizationPermissionService;

    /**
     * WebPortalYetkiIzinController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->webPortalAuthorizationPermissionService = new WebPortalAuthorizationPermissionService($request);
    }

    /**
     * @param StoreWebPortalAuthorizationPermissionRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function store(StoreWebPortalAuthorizationPermissionRequest $request): SuccessResource
    {
        $this->webPortalAuthorizationPermissionService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param DestroyWebPortalAuthorizationPermissionRequest  $request
     *
     * @return SuccessResource
     * @throws WebPortalAuthorizationPermissionNotFoundException
     */
    public function destroy(DestroyWebPortalAuthorizationPermissionRequest $request): SuccessResource
    {
        $this->webPortalAuthorizationPermissionService->destroy($request);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }

    /**
     * @param BulkWebPortalAuthorizationPermissionRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function bulk(BulkWebPortalAuthorizationPermissionRequest $request): SuccessResource
    {
        $this->webPortalAuthorizationPermissionService->bulk($request);

        return new SuccessResource(__('messages.' . self::class . '.BULK'));
    }
}
