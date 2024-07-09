<?php

namespace App\Http\Controllers\API\WebPortal;

use App\Exceptions\ForbiddenException;
use App\Exceptions\WebPortal\WebPortalAuthorizationPermissionNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebPortal\StoreWebPortalAuthorizationPermissionRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\WebPortal\WebPortalAuthorizationPermissionResource;
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

        return new SuccessResource('WEB_PORTAL_AUTHORIZATION_PERMISSION.CREATE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws WebPortalAuthorizationPermissionNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->webPortalAuthorizationPermissionService->destroy($id);

        return new SuccessResource('WEB_PORTAL_AUTHORIZATION_PERMISSION.DESTROY.SUCCESS');
    }
}
