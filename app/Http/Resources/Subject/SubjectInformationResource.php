<?php

namespace App\Http\Resources\Subject;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Utils\Security;

/**
 * Class SubjectInformationResource
 *
 * @package App\Http\Resources\Subject
 *
 * @mixin mixed
 */
class SubjectInformationResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'             => Security::encrypt($this->getKey()),
            'name'           => $this->ad,
            'state'          => $this->durum,
            'parent_id'      => Security::encrypt($this->ust_id),
            'is_main_parent' => $this->ust_id == 0,
            'type'           => SubjectInformationTypeResource::make($this->whenLoaded('type')),
            'description'    => $this->aciklama,
            'use_state'      => $this->kullanim_durum,
            'use_place_id'   => Security::encrypt($this->kullanim_yeri),
            'user_type_ids'  => $this->kullanici_tipi,
            'recorder'       => EmployeeBasicResource::make($this->whenLoaded('recorder')),
            'sub_subject'    => SubjectInformationResource::collection($this->whenLoaded('subSubject')),
        ];
    }
}
