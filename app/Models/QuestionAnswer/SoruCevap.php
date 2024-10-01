<?php

namespace App\Models\QuestionAnswer;

use App\Filters\QuestionAnswer\QuestionAnswerFilter;
use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SoruCevap
 *
 * @package App\Models\QuestionAnswer
 * @version April 19, 2024, 2:21 pm UTC
 *
 * @property int                    $id
 * @property int                    $kategori_id
 * @property string                 $soru
 * @property int                    $sayac
 * @property string                 $cevap
 * @property bool                   $durum
 * @property string                 $soru_keywords
 * @property string                 $cevap_keywords
 * @property string                 $kaydeden_ip
 * @property string                 $kayit_tarih
 *
 * @property-read SoruCevapKategori $category
 *
 * @method static Builder|SoruCevap filter(array $filters = [])
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
     * @return hasOne
     */
    public function category(): hasOne
    {
        return $this->hasOne(SoruCevapKategori::class, 'id', 'kategori_id');
    }

    /**
     * @param $filters
     *
     * @return QuestionAnswerFilter
     */
    protected function filter($filters): QuestionAnswerFilter
    {
        return new QuestionAnswerFilter($filters);
    }
}
