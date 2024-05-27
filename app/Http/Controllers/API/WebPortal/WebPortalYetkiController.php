<?php

namespace App\Http\Controllers\API\WebPortal;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebPortal\IndexWebPortalAuthorizationRequest;
use App\Http\Resources\WebPortal\WebPortalAuthorizationCollection;
use App\Services\WebPortal\WebPortalAuthorizationService;
use Illuminate\Http\Request;

/**
 * Class WebPortalYetkiController
 *
 * @package App\Http\Controllers\API\WebPortal
 */
class WebPortalYetkiController extends Controller
{
    /** @var WebPortalAuthorizationService $webPortalAuthorizationService */
    private WebPortalAuthorizationService $webPortalAuthorizationService;

    /**
     * WebPortalYetkiController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->webPortalAuthorizationService = new WebPortalAuthorizationService($request);
    }

    /**
     * @param IndexWebPortalAuthorizationRequest  $request
     *
     * @return WebPortalAuthorizationCollection
     */
    public function index(IndexWebPortalAuthorizationRequest $request): WebPortalAuthorizationCollection
    {
        $webPortalAuthorization = $this->webPortalAuthorizationService->index($request);

        return new WebPortalAuthorizationCollection($webPortalAuthorization, 'WEB_PORTAL_AUTHORIZATION.INDEX.SUCCESS');
    }
}
