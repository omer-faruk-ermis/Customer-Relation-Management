<?php

namespace App\Http\Resources\WebPortal;

use App\Http\Resources\AbstractCollection;
use App\Services\Authorization\AuthorizationService;
use App\Utils\Security;

/**
 * Class WebPortalAuthorizationPageCollection
 *
 * @package App\Http\Resources\WebPortal
 *
 * @mixin mixed
 */
class WebPortalAuthorizationPageCollection extends AbstractCollection
{
    public $collects = WebPortalAuthorizationResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        if ($request->input('employee_id')) {
            $authorizatedIds =
                (new AuthorizationService(Security::decrypt($request->input('employee_id'))))
                    ->authorization()
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
