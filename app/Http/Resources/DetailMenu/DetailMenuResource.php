<?php

namespace App\Http\Resources\DetailMenu;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Utils\DateUtil;
use App\Utils\Security;

/**
 * Class DetailMenuResource
 *
 * @package App\Http\Resources\DetailMenu
 *
 * @mixin mixed
 */
class DetailMenuResource extends AbstractResource
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
            'name'          => $this->menu_adi,
            'url'           => $this->menu_url,
            'register_date' => DateUtil::dateFormat($this->kayit_tar),
            'register_ip'   => $this->kayit_ip,
            'register_id'   => Security::encrypt($this->kayit_id),
            'state'         => $this->durum,
            'order'         => $this->sira,
            'parent_id'     => Security::encrypt($this->parentid),
            'pages'         => DetailMenuResource::collection($this->whenLoaded('pages')),
            'members'       => EmployeeBasicResource::collection($this->whenLoaded('members')),
        ];
    }
}
