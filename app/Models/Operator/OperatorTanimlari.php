<?php

namespace App\Models\Operator;

use App\Models\AbstractModel;

/**
 * Class OperatorTanimlari
 *
 * @package App\Models\Operator
 * @version August 07, 2024, 4:20 pm UTC
 *
 * @property int    $op_kodu
 * @property string $adi
 * @property string $icon_url
 * @property string $kisa_ad
 * @property int    $smscdrbildir
 * @property int    $abonecdrbildir
 * @property int    $sescdrbildir
 * @property string $ftp_name
 * @property string $ftp_pass
 * @property string $ftp_ip
 * @property int    $webuser_id
 * @property string $yonlendirme_kodu
 * @property int    $yurtdisimi
 * @property int    $btk_kodu
 */
class OperatorTanimlari extends AbstractModel
{
    protected $table = 'kaynaksms_ucretlendirme.dbo.operator_tanimlari';
}
