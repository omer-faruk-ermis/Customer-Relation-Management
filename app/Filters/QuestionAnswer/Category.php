<?php

namespace App\Filters\QuestionAnswer;

use App\Models\QuestionAnswer\SoruCevap;

class Category
{
    public function apply($query, $value): void
    {
        $soruCevap = SoruCevap::getModel();

        $query->where($soruCevap->qualifyColumn('kategori_id'), '=', $value);
    }
}
