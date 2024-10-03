<?php

namespace App\Models\WebUser;

use App\Filters\WebUser\WebUserFilter;
use App\Models\AbstractModel;
use App\Models\MaskableTrait;
use App\Models\SimCard\SimKart;
use App\Models\Subscriber\AboneNo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;

/**
 * Class WebUser
 *
 * @package App\Models\WebUser
 * @version April 19, 2024, 1:11 pm UTC
 *
 * @property int                          $id
 * @property string                       $name
 * @property string                       $pwd
 * @property string                       $ad
 * @property string                       $soyad
 * @property string                       $aciklama
 * @property int                          $tel
 * @property string                       $email
 * @property int                          $ceptel
 * @property string                       $songir_tar
 * @property bool                         $goster
 * @property string                       $ipadres
 * @property string                       $kayit_tar
 * @property string                       $kullanici_tipi
 * @property string                       $detay
 * @property int                          $telefon
 * @property string                       $adres
 * @property bool                         $odeme_tipi
 * @property string                       $kaynaksmscep
 * @property bool                         $onay
 * @property bool                         $gsm_tip
 * @property int                          $birimfiyat
 * @property int                          $ust_id
 * @property int                          $dogumid
 * @property int                          $evlilikid
 * @property string                       $tckimlik
 * @property float                        $chip_user
 * @property bool                         $tanidikmi
 * @property int                          $parayatir
 * @property int                          $dogsms_ucretsiz
 * @property bool                         $kfm_fatura_kesilen
 * @property int                          $oncelikli
 * @property bool                         $sozlesme
 * @property int                          $abone_no
 * @property bool                         $bayiarayuzu
 * @property int                          $deg_kimlik
 * @property string                       $deg_ip
 * @property int                          $deg_usr
 * @property string                       $sozlesme_tarih
 * @property int                          $dog_yil
 * @property string                       $sabittel
 * @property int                          $abonetip
 * @property string                       $kurumadi
 * @property int                          $kurumturu
 * @property int                          $kurumislemyapan
 * @property bool                         $islemtipi
 * @property string                       $sozlesme_guncel_tar
 * @property bool                         $jobsmsi_gelmesin
 * @property bool                         $aboneno_tercih
 * @property bool                         $dialerpin
 * @property string                       $sifre
 * @property bool                         $tanidiga_duyarli
 * @property int                          $abonebag
 * @property bool                         $namukerrer
 * @property bool                         $telmukerrer
 * @property int                          $kopkodu
 * @property bool                         $maxoncelik
 * @property int                          $transit_op_kodu
 * @property int                          $vergino
 * @property string                       $vergidairesi
 * @property int                          $vno
 * @property int                          $mersisno
 * @property string                       $vergidairesino
 *
 * @property string                       $full_name
 *
 * @property-read WebUserKullaniciTipleri $userType
 * @property-read AboneNo                 $subscriberNo
 * @property-read SimKart                 $simCard
 *
 * @method static Builder|WebUser filter(array $filters = [])
 */
class WebUser extends AbstractModel
{
    use MaskableTrait;

    protected $table = 'kaynaksms.dbo.webuser';

    /**
     * The attributes that should be appended to the model's array representation.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->ad . ' ' . $this->soyad;
    }

    /**
     * @return hasOne
     */
    public function userType(): hasOne
    {
        return $this->hasOne(WebUserKullaniciTipleri::class, 'ktip', 'kullanici_tipi');
    }

    /**
     * @return hasOne
     */
    public function subscriberNo(): hasOne
    {
        return $this->hasOne(AboneNo::class, 'userid', 'id')
                    ->where('durum', '=', 2);
    }

    /**
     * @return hasManyThrough
     */
    public function simCard(): hasManyThrough
    {
        return $this->hasManyThrough(
            SimKart::class,
            UserSimKartEslestir::class,
            'userid',
            'id',
            'id',
            'sim_kart_id'
        );
    }

    /**
     * @param $filters
     *
     * @return WebUserFilter
     */
    protected function filter($filters): WebUserFilter
    {
        return new WebUserFilter($filters);
    }
}
