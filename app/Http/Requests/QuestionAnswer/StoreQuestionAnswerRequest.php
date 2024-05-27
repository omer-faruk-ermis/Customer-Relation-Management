<?php

namespace App\Http\Requests\QuestionAnswer;

use App\Http\Requests\AbstractRequest;

class StoreQuestionAnswerRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['category_id'];

    public function rules(): array
    {
        return [
            'category_id'       => 'required|string',
            'question'          => 'required|string',
            'answer'            => 'required|string',
            'question_keywords' => 'required|string',
            'answer_keywords'   => 'required|string',
        ];
    }
}
