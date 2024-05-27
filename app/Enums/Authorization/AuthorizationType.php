<?php

namespace App\Enums\Authorization;

use App\Enums\AbstractEnum;

class AuthorizationType extends AbstractEnum
{
    const SMS_MANAGEMENT = 1;
    const BLUE_SCREEN = 2;
    const AUTHORIZATION = 3;
    const SUBSCRIBER_BILLET = 4;
}

