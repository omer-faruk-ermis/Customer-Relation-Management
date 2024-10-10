<?php

namespace App\Http\Resources\WebPortal;

use App\Enums\Status;
use App\Http\Resources\AbstractCollection;
use App\Services\Authorization\AuthorizationService;
use App\Utils\Security;

/**
 * Class WebPortalAuthorizationMenuCollection
 *
 * @package App\Http\Resources\WebPortal
 *
 * @mixin mixed
 */
class WebPortalAuthorizationMenuCollection extends AbstractCollection
{
    public $collects = WebPortalAuthorizationResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        $authorizatedIds = $request->input('employee_id')
            ? (new AuthorizationService(Security::decrypt($request->input('employee_id'))))
                ->authorization()
                ->where('main_authorization_state', '=', Status::ACTIVE)
                ->pluck('id')
                ->toArray()
            : [];

        return (object)[
            'app'  => $this->collection->first()->tanim,
            'menu' => $this
                ->collection
                ->groupBy('yetki_detay')
                ->map(function ($group, $key) use ($authorizatedIds) {

                    $group = $group->map(function ($menu) use ($authorizatedIds) {
                        $menu->is_authorized = in_array($menu->id, $authorizatedIds);

                        return $menu;
                    });

                    return (object)[
                        'menu'  => $key,
                        'pages' => $group
                    ];
                })
        ];
    }
}
