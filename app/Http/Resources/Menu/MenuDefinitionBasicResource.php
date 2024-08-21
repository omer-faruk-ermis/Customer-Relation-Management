<?php

namespace App\Http\Resources\Menu;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Url\UrlDefinitionBasicResource;
use App\Utils\Security;

/**
 * Class MenuDefinitionBasicResource
 *
 * @package App\Http\Resources\Menu
 *
 * @mixin mixed
 */
class MenuDefinitionBasicResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'    => Security::encrypt($this->getKey()),
            'name'  => $this->menu,
            'order' => $this->sira,
            'state' => $this->durum,
            'path'  => $this->path,
            'icon'  => $this->icon,
            'color' => $this->color,
            'pages' => UrlDefinitionBasicResource::collection($this->page_data ?? [])
        ];
    }
}
