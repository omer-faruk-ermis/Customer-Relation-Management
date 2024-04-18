<?php

namespace App\Http\Requests\QuestionAnswer;

use App\Http\Requests\AbstractRequest;

class UpdateQuestionAnswerRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'category_id'       => 'sometimes|integer',
            'question'          => 'sometimes|string',
            'answer'            => 'sometimes|string',
            'question_keywords' => 'sometimes|string',
            'answer_keywords'   => 'sometimes|string',
        ];
    }
}
