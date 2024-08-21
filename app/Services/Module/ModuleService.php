<?php

namespace App\Services\Module;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\Status;
use App\Exceptions\Module\ModuleAlreadyHaveException;
use App\Exceptions\Module\ModuleNotFoundException;
use App\Exceptions\RelationHaveException;
use App\Models\Module\Module;
use App\Services\AbstractService;
use App\Utils\Security;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class ModuleService
 *
 * @package App\Service\Module
 */
class ModuleService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::AUTHORIZED_GROUPS,
            SmsManagement::AUTHORIZED_GROUPS_GROUP,
            SmsManagement::APP_MANAGEMENT,
            SmsManagement::APP_EMPLOYEE
        ]
    ];

    /**
     * @param Request  $request
     * @param          $menus
     *
     * @return Collection
     */
    public function index(Request $request, $menus): Collection
    {
        return Module::active()
                     ->when(!empty($menus), function ($q) use ($menus) {
                         $q->whereIn('id', $menus->pluck('module_id')->toArray());
                     })
                     ->get()
                     ->map(function ($module) use ($menus) {
                         if (!empty($menus)) {
                             $menuArray = [];

                             foreach ($menus as $menu) {
                                 if ($module->id == $menu->module_id) {
                                     $menuArray[] = $menu;
                                 }
                             }

                             $module->menu_data = $menuArray;
                         }

                         return $module;
                     });
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function store(Request $request): void
    {
        $module = Module::where('name', '=', $request->input('name'))
                        ->active()
                        ->first();

        if ($module) {
            throw new ModuleAlreadyHaveException();
        }

        Module::create([
                           'name'  => $request->input('name'),
                           'panel' => $request->input('panel'),
                           'durum' => Status::ACTIVE,

                           'path'  => $request->input('path'),
                           'icon'  => $request->input('icon'),
                           'color' => $request->input('color'),
                       ]);
    }


    /**
     * @param Request  $request
     * @param string   $id
     *
     * @return Module
     * @throws ModuleNotFoundException
     */
    public function update(Request $request, string $id): Module
    {
        $module = Module::find(Security::decrypt($id));
        if (empty($module)) {
            throw new ModuleNotFoundException();
        }

        $module->update([
                            'name'  => $request->input('name', $module->name),
                            'panel' => $request->input('panel', $module->panel),

                            'path'  => $request->input('path', $module->path),
                            'icon'  => $request->input('icon', $module->icon),
                            'color' => $request->input('color', $module->color),
                        ]);

        return $module;
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws ModuleNotFoundException|RelationHaveException
     */
    public function destroy(string $id): void
    {
        $module = Module::with('menu')->where('id', Security::decrypt($id))->first();
        if (empty($module)) {
            throw new ModuleNotFoundException();
        }

        if (!empty($module->menu)) {
            throw new RelationHaveException();
        }

        $module->durum = Status::PASSIVE;
        $module->update();
    }
}
