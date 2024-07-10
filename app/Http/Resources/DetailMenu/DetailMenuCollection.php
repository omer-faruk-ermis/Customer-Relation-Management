<?php

namespace App\Http\Resources\DetailMenu;

use App\Http\Resources\AbstractCollection;
use App\Services\Authorization\AuthorizationService;
use App\Utils\Security;

/**
 * Class DetailMenuCollection
 *
 * @package App\Http\Resources\DetailMenu
 *
 * @mixin mixed
 */
class DetailMenuCollection extends AbstractCollection
{
    public $collects = DetailMenuResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        if ($request->input('employee_id')) {
            $authorizatedIds =
                (new AuthorizationService(Security::decrypt($request->input('employee_id'))))
                    ->blueScreen()
                    ->pluck('id')
                    ->toArray();

            $this->collection = $this->collection->map(function ($menu) use ($authorizatedIds) {
                $menu->is_authorized = in_array($menu->id, $authorizatedIds);

                return $menu;
            });
        }

        return $this->collection;
    }
}
