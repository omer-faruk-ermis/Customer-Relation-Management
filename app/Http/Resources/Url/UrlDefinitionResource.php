<?php

namespace App\Http\Resources\Url;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Http\Resources\Menu\MenuDefinitionResource;

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
            'id'            => $this->getKey(),
            'name'          => $this->adi,
            'url'           => $this->url,
            'color'         => $this->color,
            'icon'          => $this->icon,
            'menu_id'       => $this->ust_id,
            'state'         => $this->durum,
            'is_authorized' => $this->is_authorized,
            'background_id' => $this->arkaplan_id,
            'tab_id'        => $this->tab_id,
            'recorder'      => EmployeeBasicResource::make($this->whenLoaded('recorder')),
            'menu'          => MenuDefinitionResource::make($this->whenLoaded('menu')),
            'members'       => EmployeeBasicResource::collection($this->whenLoaded('authorizations'))
        ];
    }
}
