<?php

namespace App\Enums\Call;

use App\Enums\AbstractEnum;

class CallDirection extends AbstractEnum
{

    public const ALL = '*';
    public const INCOMING_CALL = [0, 1];
    public const OUTGOING_CALL = 2;
}
