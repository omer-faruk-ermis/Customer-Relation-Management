<?php

namespace App\Enums\Authorization;

use App\Enums\AbstractEnum;

class SubscriberBillet extends AbstractEnum
{
    const SHOW_IDENTITY_NO = 1;
    const SHOW_PHONE_NO = 2;
    const SHOW_BIRTHDAY_DATE = 3;
    const SHOW_IDENTITY_SERIAL_NO = 4;
    const SHOW_MAIL = 5;
}
