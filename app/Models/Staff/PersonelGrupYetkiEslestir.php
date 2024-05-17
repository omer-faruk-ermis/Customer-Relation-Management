<?php

namespace App\Models\Staff;

use App\Models\AbstractModel;
use App\Models\Url\UrlTanim;

/**
 * Class PersonelGrupYetkiEslestir
 *
 * @package App\Models\Staff
 * @version April 29, 2024, 2:05 pm UTC
 *
 * @property int           $id
 * @property int           $personel_grup_id
 * @property int           $yetki_id
 * @property bool          $durum
 * @property int           $tip
 * @property string        $kayit_tarihi
 * @property int           $sms_kimlik
 *
 * @property-read UrlTanim $smsManagement
 * @property-read UrlTanim $blueScreen
 * @property-read UrlTanim $authorization
 * @property-read UrlTanim $subscriberBillet
 */
class PersonelGrupYetkiEslestir extends AbstractModel
{
    use AuthorizationTrait;

    protected $table = 'kaynaksms_diger.dbo.personel_grup_yetki_eslestir';
}
