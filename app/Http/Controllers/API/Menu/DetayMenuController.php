<?php

namespace App\Http\Controllers\API\Menu;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailMenu\IndexDetailMenuPageRequest;
use App\Http\Requests\DetailMenu\IndexDetailMenuRequest;
use App\Http\Resources\DetailMenu\DetailMenuCollection;
use App\Services\Menu\DetailMenuService;
use Illuminate\Http\Request;

/**
 * Class DetayMenuController
 *
 * @package App\Http\Controllers\API\Menu
 */
class DetayMenuController extends Controller
{
    /** @var DetailMenuService $detailMenuService */
    private DetailMenuService $detailMenuService;

    /**
     * DetayMenuController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->detailMenuService = new DetailMenuService($request);
    }

    /**
     * @param IndexDetailMenuRequest $request
     *
     * @return DetailMenuCollection
     */
    public function menu(IndexDetailMenuRequest $request): DetailMenuCollection
    {
        $detailMenu = $this->detailMenuService->menu($request);

        return new DetailMenuCollection($detailMenu, __('messages.' . self::class . '.MENU.INDEX'));
    }

    /**
     * @param IndexDetailMenuPageRequest $request
     *
     * @return DetailMenuCollection
     */
    public function page(IndexDetailMenuPageRequest $request): DetailMenuCollection
    {
        $detailMenuPage = $this->detailMenuService->page($request);

        return new DetailMenuCollection($detailMenuPage, __('messages.' . self::class . '.PAGE.INDEX'));
    }
}
