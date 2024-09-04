<?php

namespace App\Enums\Authorization;

use App\Enums\AbstractEnum;

class AuthorizationType extends AbstractEnum
{
    public const SMS_MANAGEMENT = 1;
    public const BLUE_SCREEN = 2;
    public const AUTHORIZATION = 3;
    public const SUBSCRIBER_BILLET = 4;
}

