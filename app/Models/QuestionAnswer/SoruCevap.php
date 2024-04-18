<?php

namespace App\Models\QuestionAnswer;

use App\Filters\QuestionAnswer\QuestionAnswerFilter;
use App\Models\AbstractModel;

/**
 * Class Sebepler
 *
 * @package App\Models
 */
class SoruCevap extends AbstractModel
{
    protected $table = 'crm.dbo.soru_cevap';

    protected $fillable = [
        'kategori_id',
        'soru',
        'sayac',
        'cevap',
        'durum',
        'soru_keywords',
        'cevap_keywords',
        'kaydeden_ip',
        'kayit_tarih'
    ];

    /**
     * @param $filters
     * @return QuestionAnswerFilter
     */
    protected function filter($filters): QuestionAnswerFilter
    {
        return new QuestionAnswerFilter($filters);
    }
}
