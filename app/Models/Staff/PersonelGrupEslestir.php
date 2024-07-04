<?php

namespace App\Models\Staff;

use App\Enums\Status;
use App\Models\AbstractModel;
use App\Models\RecorderTrait;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class PersonelGrupEslestir
 *
 * @package App\Models\Staff
 * @version April 29, 2024, 2:10 pm UTC
 *
 * @property int            $id
 * @property int            $personel_grup_id
 * @property int            $personel_id
 * @property bool           $durum
 * @property string         $kayit_tarihi
 * @property string         $son_gecerlilik_tarihi
 * @property int            $sms_kimlik
 *
 * @property-read SmsKimlik $recorder
 * @property-read SmsKimlik $staff
 */
class PersonelGrupEslestir extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.personel_grup_eslestir';

    public string $recordField = 'sms_kimlik';

    use RecorderTrait;

    protected $fillable = [
        'personel_grup_id',
        'personel_id',
        'durum',
        'kayit_tarihi',
        'sms_kimlik'
    ];

    /**
     * @return hasOne
     */
    public function staff(): hasOne
    {
        return $this->hasOne(SmsKimlik::class, 'id', 'personel_id')
                    ->where('durum', '=', Status::ACTIVE);
    }
}
