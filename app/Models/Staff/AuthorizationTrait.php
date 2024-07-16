<?php

namespace App\Models\Staff;

use App\Enums\Authorization\AuthorizationType;
use App\Enums\Status;
use App\Models\Url\UrlTanim;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait AuthorizationTrait
 *
 * @package App\Models\Staff
 */
trait AuthorizationTrait
{
    /**
     * @param string  $authorizationType
     *
     * @return HasMany
     */
    private function getAuthorizationQuery(string $authorizationType): HasMany
    {
        $pgyEslestir = self::getModel();
        $urlTanim = UrlTanim::getModel();

        return $this->hasMany(UrlTanim::class, 'id', 'yetki_id')
                    ->join(
                        $pgyEslestir->getTable(),
                        $urlTanim->getQualifiedKeyName(),
                        '=',
                        $pgyEslestir->qualifyColumn('yetki_id'))
                    ->where($pgyEslestir->qualifyColumn('tip'), '=', $authorizationType)
                    ->where($urlTanim->qualifyColumn('durum'), '=', Status::ACTIVE)
                    ->where($pgyEslestir->qualifyColumn('durum'), '=', Status::ACTIVE);
    }

    /**
     * @return HasMany|null
     */
    public function smsManagement(): ?HasMany
    {
        return $this->getAuthorizationQuery(AuthorizationType::SMS_MANAGEMENT);
    }

    /**
     * @return HasMany
     */
    public function blueScreen(): HasMany
    {
        return $this->getAuthorizationQuery(AuthorizationType::BLUE_SCREEN);
    }

    /**
     * @return HasMany
     */
    public function authorization(): HasMany
    {
        return $this->getAuthorizationQuery(AuthorizationType::AUTHORIZATION);
    }

    /**
     * @return HasMany
     */
    public function subscriberBillet(): HasMany
    {
        return $this->getAuthorizationQuery(AuthorizationType::SUBSCRIBER_BILLET);
    }
}
