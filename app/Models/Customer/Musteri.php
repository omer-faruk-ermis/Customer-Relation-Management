<?php

namespace App\Models\Customer;

use App\Models\AbstractModel;
use App\Models\MaskableTrait;

/**
 * Class Musteri
 *
 * @package App\Models\Customer
 * @version July 05, 2024, 0:11 pm UTC
 *
 * @property int    $id
 * @property string $ad
 * @property string $cep_tel
 * @property string $sabit_tel
 * @property string $sabit_tel2
 * @property string $email
 * @property string $fax
 * @property string $sube
 * @property int    $sektor
 * @property string $adres
 * @property string $aciklama
 * @property int    $userid
 * @property int    $kayit_id
 * @property string $kayit_ip
 * @property string $kayit_tarih
 * @property int    $gorusme_id
 * @property string $il
 * @property string $ilce
 * @property string $semt
 * @property bool   $durum
 * @property int    $abone_yapan_id
 * @property string $abone_kayit_tarih
 * @property string $gorusulen_kisi
 * @property int    $toplu_sms_durum
 * @property string $email2
 * @property int    $demo_durum
 * @property int    $musteri_tipi
 * @property string $musteri_tip_tarihi
 * @property string $calistigi_firma
 * @property string $talep_id
 * @property int    $nerden
 * @property int    $aktif
 * @property int    $takip_sonuc
 * @property int    $ref_user
 * @property int    $hediye_durum
 * @property int    $hediye_turu
 * @property int    $kulv_id
 * @property int    $bayi_userid
 * @property string $aciklama1
 */
class Musteri extends AbstractModel
{
    use MaskableTrait;

    protected $table = 'kaynaksms_diger.dbo.musteri';
}
