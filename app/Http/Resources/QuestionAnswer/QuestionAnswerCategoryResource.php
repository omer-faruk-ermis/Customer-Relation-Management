<?php

namespace App\Http\Resources\QuestionAnswer;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Log\ReasonLogResource;
use App\Utils\Security;

/**
 * Class QuestionAnswerCategoryResource
 *
 * @package App\Http\Resources\QuestionAnswer
 *
 * @mixin mixed
 */
class QuestionAnswerCategoryResource extends AbstractResource
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
            'category_name'  => $this->kategori_adi,
            'category_state' => $this->kategori_durum,
        ];
    }
}
