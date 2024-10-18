<?php

namespace App\Enums;

class AgreementType extends AbstractEnum
{
    public const ALL = '*';
    public const ACTIVE = 1;
    public const PASSIVE = 0;
    public const MEMBER = 2;
}
