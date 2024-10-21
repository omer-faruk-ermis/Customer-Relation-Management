<?php

namespace App\Enums;

class AgreementType extends AbstractEnum
{
    public const PASSIVE = 0;
    public const ACTIVE = 1;
    public const MEMBER = 2;
    public const ALL = '*';
}
