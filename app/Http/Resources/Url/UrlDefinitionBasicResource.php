<?php

namespace App\Http\Resources\Url;

use App\Http\Resources\AbstractResource;

/**
 * Class UrlDefinitionBasicResource
 *
 * @package App\Http\Resources\Url
 *
 * @mixin mixed
 */
class UrlDefinitionBasicResource extends AbstractResource
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
        ];
    }
}
