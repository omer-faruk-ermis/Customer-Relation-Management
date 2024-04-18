<?php

namespace App\Filters\QuestionAnswer;

use App\Models\QuestionAnswer\SoruCevap;

class Answer
{
    public function apply($query, $value): void
    {
        $soruCevap = SoruCevap::getModel();

        $query->where($soruCevap->qualifyColumn('cevap'), 'LIKE', '%' . $value . '%');
    }
}
