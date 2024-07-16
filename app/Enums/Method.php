<?php

namespace App\Enums;

class Method extends AbstractEnum
{
    const INDEX = 'index';
    const SHOW = 'show';
    const BASIC = 'basic';
    const STORE = 'store';
    const UPDATE = 'update';
    const DESTROY = 'destroy';
    const BULK = 'bulk';
}
