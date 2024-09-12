<?php

namespace App\Enums;

class RegexPattern extends AbstractEnum
{
    const EMAIL = '/[@.]|^(com|net|org|edu|gov|mil|co|biz|info|io)$/i';
    const ARRAY_CHECK = '/^\[.*]$/';
    const PASSWORD = '/^[^\x22\x27]+$/u';
    const TOKEN = '/^[a-zA-Z0-9]+$/';
    const COMMA_SPLIT = '/\s*,\s*/';
    const TRACE_LIST = '/#(\d+) .+/';
}
