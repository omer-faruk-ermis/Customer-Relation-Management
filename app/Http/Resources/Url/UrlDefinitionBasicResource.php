<?php

namespace App\Http\Resources\Url;

use App\Http\Resources\AbstractResource;
use App\Utils\Security;

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
            'id'            => Security::encrypt($this->getKey()),
            'name'          => $this->adi,
            'url'           => $this->url,
            'menu_id'       => Security::encrypt($this->ust_id),
            'state'         => $this->durum,
            'is_authorized' => $this->is_authorized,
            'background_id' => Security::encrypt($this->arkaplan_id),
            'tab_id'        => Security::encrypt($this->tab_id),
        ];
    }
}
