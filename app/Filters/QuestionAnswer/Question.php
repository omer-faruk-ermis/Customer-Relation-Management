<?php

namespace App\Filters\QuestionAnswer;

use App\Models\QuestionAnswer\SoruCevap;

class Question
{
    public function apply($query, $value): void
    {
        $soruCevap = SoruCevap::getModel();

        $query->where($soruCevap->qualifyColumn('soru'), 'LIKE', '%' . $value . '%');
    }
}
