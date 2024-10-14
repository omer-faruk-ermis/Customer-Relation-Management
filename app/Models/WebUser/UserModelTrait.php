<?php

namespace App\Models\WebUser;

use App\Enums\CustomerPriority;
use App\Models\Subscriber\AboneNo;
use App\Models\Subscriber\Pilot\PilotAbone;
use App\Models\Subscriber\VipOzelMusteriEslestir;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait UserModelTrait
 *
 * @package App\Models\WebUser
 */
trait UserModelTrait
{
    /**
     * @return hasOne
     */
    public function dealerUser(): hasOne
    {
        return $this->hasOne(WebUser::class, 'ust_id', 'id');
    }

    /**
     * @return hasOne
     */
    public function special(): hasOne
    {
        return $this->hasOne(VipOzelMusteriEslestir::class, 'userid', 'id')
                    ->where('tip', CustomerPriority::SPECIAL)
                    ->active();
    }

    /**
     * @return hasOne
     */
    public function vip(): hasOne
    {
        return $this->hasOne(VipOzelMusteriEslestir::class, 'userid', 'id')
                    ->where('tip', CustomerPriority::VIP)
                    ->active();
    }

    /**
     * @return hasOne
     */
    public function subscriber(): hasOne
    {
        return $this->hasOne(AboneNo::class, 'userid', 'id')
            ->where('durum', '=', 2);
    }

    /**
     * @return hasOne
     */
    public function pilot(): hasOne
    {
        return $this->hasOne(PilotAbone::class, 'pilot_userid', 'id')
                    ->active();
    }
}
