<?php

namespace App\Enums\Authorization;

use App\Enums\AbstractEnum;

class AuthorizationTypeName extends AbstractEnum
{
    const SMS_MANAGEMENT = 'sms_management';
    const BLUE_SCREEN = 'blue_screen';
    const AUTHORIZATION = 'authorization';
    const SUBSCRIBER_BILLET = 'subscriber_billet';
}

