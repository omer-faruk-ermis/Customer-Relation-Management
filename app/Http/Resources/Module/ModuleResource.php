<?php

namespace App\Http\Resources\Module;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Menu\MenuDefinitionBasicResource;
use App\Utils\Security;

/**
 * Class ModuleResource
 *
 * @package App\Http\Resources\Module
 *
 * @mixin mixed
 */
class ModuleResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->getKey(),
            'encrypt_id' => Security::encrypt($this->getKey()),
            'name'       => $this->name,
            'panel'      => $this->panel,
            'state'      => $this->durum,
            'path'       => $this->path,
            'icon'       => $this->icon,
            'color'      => $this->color,
            'menu'       => MenuDefinitionBasicResource::collection($this->menu_data ?? [])
        ];
    }
}
