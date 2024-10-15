<?php

namespace App\Http\Requests\QuestionAnswer;

use App\Http\Requests\AbstractRequest;

class UpdateQuestionAnswerRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['category_id'];
    */

    public function rules(): array
    {
        return [
            'category_id'       => 'sometimes|string',
            'question'          => 'sometimes|string',
            'answer'            => 'sometimes|string',
            'question_keywords' => 'sometimes|string',
            'answer_keywords'   => 'sometimes|string',
        ];
    }
}
