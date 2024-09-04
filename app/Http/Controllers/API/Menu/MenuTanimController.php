<?php

namespace App\Http\Controllers\API\Menu;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Menu\MenuNotFoundException;
use App\Exceptions\RelationHaveException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\IndexMenuDefinitionRequest;
use App\Http\Requests\Menu\StoreMenuDefinitionRequest;
use App\Http\Requests\Menu\UpdateMenuDefinitionRequest;
use App\Http\Resources\Menu\MenuDefinitionCollection;
use App\Http\Resources\Menu\MenuDefinitionResource;
use App\Http\Resources\SuccessResource;
use App\Services\Menu\MenuDefinitionService;
use Exception;
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
        $menuDefinition = $this->menuDefinitionService->menu($request, []);

        return new MenuDefinitionCollection($menuDefinition, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreMenuDefinitionRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function store(StoreMenuDefinitionRequest $request): SuccessResource
    {
        $this->menuDefinitionService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param UpdateMenuDefinitionRequest  $request
     * @param string                      $id
     *
     * @return MenuDefinitionResource
     * @throws MenuNotFoundException
     */
    public function update(UpdateMenuDefinitionRequest $request, string $id): MenuDefinitionResource
    {
        $employee = $this->menuDefinitionService->update($request, $id);

        return new MenuDefinitionResource($employee, __('messages.' . self::class . '.UPDATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws MenuNotFoundException|RelationHaveException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->menuDefinitionService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
