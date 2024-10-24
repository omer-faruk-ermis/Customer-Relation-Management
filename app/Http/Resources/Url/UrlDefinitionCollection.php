<?php

namespace App\Http\Resources\Url;

use App\Enums\Status;
use App\Http\Resources\AbstractCollection;
use App\Services\Authorization\AuthorizationService;

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
                (new AuthorizationService($request->input('employee_id')))
                    ->smsManagement()
                    ->where('main_authorization_state', '=', Status::ACTIVE)
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
