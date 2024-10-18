<?php

namespace App\Http\Resources\QuestionAnswer;

use App\Http\Resources\AbstractResource;

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
            'id'             => $this->getKey(),
            'category_name'  => $this->kategori_adi,
            'category_state' => $this->kategori_durum,
        ];
    }
}
