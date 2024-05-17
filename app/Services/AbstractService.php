<?php

namespace App\Services;

use App\Enums\Authorization\AuthorizationType;
use App\Models\Menu\DetayMenu;
use App\Models\Url\UrlTanim;

/**
 * Abstract class AbstractService
 *
 * @package App\Services
 */
abstract class AbstractService
{
    protected array $serviceName = [];

    protected function checkPermission()
    {
        if (AuthorizationType::SMS_MANAGEMENT === key($this->serviceName)) {
            return UrlTanim::find($this->serviceName[AuthorizationType::SMS_MANAGEMENT])->exists();
        }

        if (AuthorizationType::BLUE_SCREEN === key($this->serviceName)) {
            return DetayMenu::find($this->serviceName[AuthorizationType::BLUE_SCREEN])->exists();
        }
    }
}
