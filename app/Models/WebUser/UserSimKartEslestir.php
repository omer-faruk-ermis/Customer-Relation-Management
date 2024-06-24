<?php

namespace App\Models\WebUser;

use App\Models\AbstractModel;

/**
 * Class UserSimKartEslestir
 *
 * @package App\Models\WebUser
 * @version June 20, 2024, 10:54 pm UTC
 *
 * @property int    $id
 * @property int    $userid
 * @property int    $sim_kart_id
 * @property int    $durum
 * @property string $kayit_tarihi
 * @property int    $sms_kimlik
 * @property int    $subscriber_id
 */
class UserSimKartEslestir extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.user_sim_kart_eslestir';
}
