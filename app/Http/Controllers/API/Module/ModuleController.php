<?php

namespace App\Http\Controllers\API\Module;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Module\ModuleNotFoundException;
use App\Exceptions\RelationHaveException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\IndexMenuDefinitionRequest;
use App\Http\Requests\Menu\StoreMenuDefinitionRequest;
use App\Http\Requests\Module\IndexModuleRequest;
use App\Http\Requests\Module\StoreModuleRequest;
use App\Http\Requests\Module\UpdateModuleRequest;
use App\Http\Resources\Menu\MenuDefinitionCollection;
use App\Http\Resources\Module\ModuleCollection;
use App\Http\Resources\Module\ModuleResource;
use App\Http\Resources\SuccessResource;
use App\Services\Menu\MenuDefinitionService;
use App\Services\Module\ModuleService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class ModuleController
 *
 * @package App\Http\Controllers\API\Module
 */
class ModuleController extends Controller
{
    /** @var ModuleService $moduleService */
    private ModuleService $moduleService;

    /**
     * ModuleController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->moduleService = new ModuleService($request);
    }

    /**
     * @param IndexModuleRequest $request
     *
     * @return ModuleCollection
     */
    public function index(IndexModuleRequest $request): ModuleCollection
    {
        $modules = $this->moduleService->index($request, []);

        return new ModuleCollection($modules, 'MODULE.INDEX.SUCCESS');
    }

    /**
     * @param StoreModuleRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function store(StoreModuleRequest $request): SuccessResource
    {
        $this->moduleService->store($request);

        return new SuccessResource('MODULE.CREATE.SUCCESS');
    }

    /**
     * @param UpdateModuleRequest  $request
     * @param string                      $id
     *
     * @return ModuleResource
     * @throws ModuleNotFoundException
     */
    public function update(UpdateModuleRequest $request, string $id): ModuleResource
    {
        $module = $this->moduleService->update($request, $id);

        return new ModuleResource($module, 'MODULE.UPDATE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws ModuleNotFoundException|RelationHaveException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->moduleService->destroy($id);

        return new SuccessResource('MODULE.DESTROY.SUCCESS');
    }
}
