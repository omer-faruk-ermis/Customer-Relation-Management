<?php

namespace App\Models\QuestionAnswer;

use App\Models\AbstractModel;

/**
 * Class SoruCevapKategori
 *
 * @package App\Models\QuestionAnswer
 * @version April 19, 2024, 2:21 pm UTC
 *
 * @property int    $id
 * @property string $kategori_adi
 * @property bool   $kategori_durum
 */
class SoruCevapKategori extends AbstractModel
{
    protected $table = 'crm.dbo.soru_cevap_kategori';

    protected $fillable = [
        'kategori_adi',
        'kategori_durum'
    ];
}
