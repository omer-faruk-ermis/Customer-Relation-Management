<?php

namespace App\Filters\QuestionAnswer;

use App\Models\QuestionAnswer\SoruCevap;

class AnswerKeywords
{
    public function apply($query, $value): void
    {
        $soruCevap = SoruCevap::getModel();

        $query->where($soruCevap->qualifyColumn('cevap_keywords'), 'LIKE', '%' . $value . '%');
    }
}
