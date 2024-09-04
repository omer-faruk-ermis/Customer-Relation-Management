<?php

namespace App\Http\Controllers\API\WebPortal;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebPortal\IndexWebPortalAuthorizationRequest;
use App\Http\Resources\WebPortal\WebPortalAuthorizationCollection;
use App\Http\Resources\WebPortal\WebPortalAuthorizationPageCollection;
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
    public function menu(IndexWebPortalAuthorizationRequest $request): WebPortalAuthorizationCollection
    {
        $webPortalAuthorization = $this->webPortalAuthorizationService->menu($request);

        return new WebPortalAuthorizationCollection($webPortalAuthorization, __('messages.' . self::class . '.MENU.INDEX'));
    }

    /**
     * @param IndexWebPortalAuthorizationRequest  $request
     *
     * @return WebPortalAuthorizationPageCollection
     */
    public function page(IndexWebPortalAuthorizationRequest $request): WebPortalAuthorizationPageCollection
    {
        $webPortalAuthorization = $this->webPortalAuthorizationService->page($request);

        return new WebPortalAuthorizationPageCollection($webPortalAuthorization, __('messages.' . self::class . '.PAGE.INDEX'));
    }
}
