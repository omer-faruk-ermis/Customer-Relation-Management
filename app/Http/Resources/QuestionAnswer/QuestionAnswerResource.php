<?php

namespace App\Http\Resources\QuestionAnswer;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Log\ReasonLogResource;
use App\Utils\DateUtil;
use App\Utils\Security;

/**
 * Class QuestionAnswerResource
 *
 * @package App\Http\Resources\QuestionAnswer
 *
 * @mixin mixed
 */
class QuestionAnswerResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                => Security::encrypt($this->getKey()),
            'category_id'       => Security::encrypt($this->category_id),
            'question'          => $this->soru,
            'answer'            => $this->cevap,
            'counter'           => $this->sayac,
            'state'             => $this->durum,
            'question_keywords' => $this->soru_keywords,
            'answer_keywords'   => $this->cevap_keywords,
            'register_ip'       => $this->kaydeden_ip,
            'register_date'     => DateUtil::dateFormat($this->kayit_tarih),
            'category'          => QuestionAnswerCategoryResource::make($this->whenLoaded('category')),
        ];
    }
}
