<?php

namespace App\Http\Resources\DetailMenu;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicCollection;
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
            'is_authorized' => $this->is_authorized,
            'order'         => $this->sira,
            'parent_id'     => Security::encrypt($this->parentid),
            'pages'         => DetailMenuCollection::make($this->whenLoaded('pages')),
            'members'       => $this->whenLoaded('detail', function ($data) {
                return EmployeeBasicCollection::make($data);
            }),
        ];
    }
}
