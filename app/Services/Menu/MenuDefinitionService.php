<?php

namespace App\Services\Menu;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\Status;
use App\Exceptions\Menu\MenuAlreadyHaveException;
use App\Exceptions\Menu\MenuNotFoundException;
use App\Exceptions\RelationHaveException;
use App\Models\Menu\MenuTanim;
use App\Services\AbstractService;
use App\Utils\Security;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class MenuDefinitionService
 *
 * @package App\Service\Menu
 */
class MenuDefinitionService extends AbstractService
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
     * @param Request   $request
     * @param           $pages
     *
     * @return Collection
     */
    public function menu(Request $request, $pages): Collection
    {
        return MenuTanim::when(!empty($pages), function ($q) use ($pages) {
            $q->whereIn('id', $pages->pluck('ust_id')->toArray());
        }, function ($q) {
            $q->with(['pages']);
        })
                        ->active()
                        ->orderBy('sira')
                        ->get()
                        ->map(function ($menu) use ($pages) {
                            if (!empty($pages)) {
                                $pageArray = [];

                                foreach ($pages as $page) {
                                    if ($menu->id == $page->ust_id) {
                                        $pageArray[] = $page;
                                    }
                                }

                                $menu->page_data = $pageArray;
                            }

                            return $menu;
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
        $menuDefinition = MenuTanim::where('module_id', '=', $request->input('module_id'))
                                   ->where('menu', '=', $request->input('name'))
                                   ->active()
                                   ->first();

        if ($menuDefinition) {
            throw new MenuAlreadyHaveException();
        }

        MenuTanim::create([
                              'menu'      => $request->input('name'),
                              'module_id' => $request->input('module_id'),
                              'sira'      => (MenuTanim::latest('id')->first())->sira + 1,
                              'durum'     => Status::ACTIVE,

                              'path'  => $request->input('path'),
                              'icon'  => $request->input('icon'),
                              'color' => $request->input('color'),
                          ]);
    }


    /**
     * @param Request  $request
     * @param string   $id
     *
     * @return MenuTanim
     * @throws MenuNotFoundException
     */
    public function update(Request $request, string $id): MenuTanim
    {
        $menuDefinition = MenuTanim::find(Security::decrypt($id));
        if (empty($menuDefinition)) {
            throw new MenuNotFoundException();
        }

        $menuDefinition->update([
                                    'menu'      => $request->input('name', $menuDefinition->menu),
                                    'module_id' => $request->input('module_id', $menuDefinition->module_id),

                                    'path'  => $request->input('path', $menuDefinition->path),
                                    'icon'  => $request->input('icon', $menuDefinition->icon),
                                    'color' => $request->input('color', $menuDefinition->color),
                                ]);

        return $menuDefinition;
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws MenuNotFoundException|RelationHaveException
     */
    public function destroy(string $id): void
    {
        $menuDefinition = MenuTanim::with('pages')->where('id', Security::decrypt($id))->first();
        if (empty($menuDefinition)) {
            throw new MenuNotFoundException();
        }

        if (!empty($menuDefinition->pages)) {
            throw new RelationHaveException();
        }

        $menuDefinition->durum = Status::PASSIVE;
        $menuDefinition->update();
    }
}
