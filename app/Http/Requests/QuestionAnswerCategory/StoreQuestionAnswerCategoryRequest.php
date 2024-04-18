<?php

namespace App\Http\Requests\QuestionAnswerCategory;

use App\Http\Requests\AbstractRequest;

class StoreQuestionAnswerCategoryRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'category_name' => 'required|string',
        ];
    }
}
