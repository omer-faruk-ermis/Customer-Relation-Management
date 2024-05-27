<?php

namespace App\Http\Controllers\API\Menu;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\IndexMenuDefinitionRequest;
use App\Http\Resources\Menu\MenuDefinitionCollection;
use App\Services\Menu\MenuDefinitionService;
use Illuminate\Http\Request;

/**
 * Class MenuTanimController
 *
 * @package App\Http\Controllers\API\Menu
 */
class MenuTanimController extends Controller
{
    /** @var MenuDefinitionService $menuDefinitionService */
    private MenuDefinitionService $menuDefinitionService;

    /**
     * MenuTanimController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->menuDefinitionService = new MenuDefinitionService($request);
    }

    /**
     * @param IndexMenuDefinitionRequest $request
     *
     * @return MenuDefinitionCollection
     */
    public function menu(IndexMenuDefinitionRequest $request): MenuDefinitionCollection
    {
        $menuDefinition = $this->menuDefinitionService->menu($request);

        return new MenuDefinitionCollection($menuDefinition, 'SMS_MANAGEMENT_MENU.INDEX.SUCCESS');
    }
}
