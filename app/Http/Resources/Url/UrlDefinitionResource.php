<?php

namespace App\Http\Resources\Url;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Http\Resources\Menu\MenuDefinitionResource;
use App\Utils\Security;

/**
 * Class UrlDefinitionResource
 *
 * @package App\Http\Resources\Url
 *
 * @mixin mixed
 */
class UrlDefinitionResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'            => Security::encrypt($this->getKey()),
            'name'          => $this->adi,
            'url'           => $this->url,
            'menu_id'       => Security::encrypt($this->ust_id),
            'state'         => $this->durum,
            'is_authorized' => $this->is_authorized,
            'background_id' => Security::encrypt($this->arkaplan_id),
            'tab_id'        => Security::encrypt($this->tab_id),
            'recorder'      => EmployeeBasicResource::make($this->whenLoaded('recorder')),
            'menu'          => MenuDefinitionResource::make($this->whenLoaded('menu')),
            'members'       => EmployeeBasicResource::collection($this->whenLoaded('authorizations'))
        ];
    }
}
