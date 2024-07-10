<?php

namespace App\Http\Resources\Url;

use App\Http\Resources\AbstractCollection;
use App\Services\Authorization\AuthorizationService;
use App\Utils\Security;

/**
 * Class UrlDefinitionCollection
 *
 * @package App\Http\Resources\Url
 *
 * @mixin mixed
 */
class UrlDefinitionCollection extends AbstractCollection
{
    public $collects = UrlDefinitionResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        if ($request->input('employee_id')) {
            $authorizatedIds =
                (new AuthorizationService(Security::decrypt($request->input('employee_id'))))
                    ->smsManagement()
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
