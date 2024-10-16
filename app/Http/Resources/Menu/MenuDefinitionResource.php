<?php

namespace App\Http\Resources\Menu;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Url\UrlDefinitionCollection;

/**
 * Class MenuDefinitionResource
 *
 * @package App\Http\Resources\Menu
 *
 * @mixin mixed
 */
class MenuDefinitionResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->getKey(),
            'name'        => $this->menu,
            'order'       => $this->sira,
            'state'       => $this->durum,
            'path'        => $this->path,
            'icon'        => $this->icon,
            'color'       => $this->color,
            'module_id'   => $this->module_id,
            'module_name' => $this->module->name ?? null,
            'pages'       => UrlDefinitionCollection::make($this->whenLoaded('pages'))
        ];
    }
}
