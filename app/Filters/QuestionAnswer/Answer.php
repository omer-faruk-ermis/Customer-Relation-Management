<?php

namespace App\Filters\QuestionAnswer;

use App\Models\QuestionAnswer\SoruCevap;

class Answer
{
    public function apply($query, $value): void
    {
        $soruCevap = SoruCevap::getModel();

        $query->whereLike($soruCevap->qualifyColumn('cevap'), $value);
    }
}
