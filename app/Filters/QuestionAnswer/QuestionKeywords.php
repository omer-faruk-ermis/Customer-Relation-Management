<?php

namespace App\Filters\QuestionAnswer;

use App\Models\QuestionAnswer\SoruCevap;

class QuestionKeywords
{
    public function apply($query, $value): void
    {
        $soruCevap = SoruCevap::getModel();

        $query->where($soruCevap->qualifyColumn('soru_keywords'), 'LIKE', '%' . $value . '%');
    }
}
