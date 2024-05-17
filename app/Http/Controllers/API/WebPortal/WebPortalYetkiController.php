<?php

namespace App\Http\Controllers\API\WebPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebPortal\IndexWebPortalAuthorizationRequest;
use App\Http\Resources\WebPortal\WebPortalAuthorizationCollection;
use App\Services\WebPortal\WebPortalAuthorizationService;

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
     */
    public function __construct()
    {
        $this->webPortalAuthorizationService = new WebPortalAuthorizationService();
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
