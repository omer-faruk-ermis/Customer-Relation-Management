<?php

namespace App\Filters\QuestionAnswer;

use App\Filters\AbstractFilter;

class QuestionAnswerFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'category_id'       => Category::class,
            'question'          => Question::class,
            'answer'            => Answer::class,
            'question_keywords' => QuestionKeywords::class,
            'answer_keywords'   => AnswerKeywords::class,
            'min_date'          => MinDate::class,
            'max_date'          => MaxDate::class,
        ];
    }
}
