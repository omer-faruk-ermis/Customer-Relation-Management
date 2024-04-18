<?php

namespace App\Models\QuestionAnswer;

use App\Models\AbstractModel;

/**
 * Class Sebepler
 *
 * @package App\Models
 */
class SoruCevapKategori extends AbstractModel
{
    protected $table = 'crm.dbo.soru_cevap_kategori';

    protected $fillable = [
        'kategori_adi',
        'kategori_durum'
    ];
}
