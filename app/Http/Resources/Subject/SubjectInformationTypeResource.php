<?php

namespace App\Http\Resources\Subject;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Utils\Security;

/**
 * Class SubjectInformationTypeResource
 *
 * @package App\Http\Resources\Subject
 *
 * @mixin mixed
 */
class SubjectInformationTypeResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'    => Security::encrypt($this->tipid),
            'color' => $this->color,
        ];
    }
}
