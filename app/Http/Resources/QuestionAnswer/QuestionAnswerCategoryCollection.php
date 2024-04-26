<?php

namespace App\Http\Resources\QuestionAnswer;

use App\Http\Resources\AbstractCollection;

/**
 * Class QuestionAnswerCategoryCollection
 *
 * @package App\Http\Resources\QuestionAnswer
 *
 * @mixin mixed
 */
class QuestionAnswerCategoryCollection extends AbstractCollection
{
    public $collects = QuestionAnswerCategoryResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
