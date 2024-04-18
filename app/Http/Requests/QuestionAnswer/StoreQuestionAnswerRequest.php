<?php

namespace App\Http\Requests\QuestionAnswer;

use App\Http\Requests\AbstractRequest;

class StoreQuestionAnswerRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'category_id'       => 'required|integer',
            'question'          => 'required|string',
            'answer'            => 'required|string',
            'question_keywords' => 'required|string',
            'answer_keywords'   => 'required|string',
        ];
    }
}
