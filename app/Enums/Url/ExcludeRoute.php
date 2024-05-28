<?php

namespace App\Enums\Url;

use App\Enums\AbstractEnum;

class ExcludeRoute extends AbstractEnum
{
    public const SECURITY_CODE = 'api/security_code';
    public const SMS_CODE = 'api/sms_code';
    public const LOGIN = 'api/login';
    public const SMS_VERIFICATION = 'api/sms_verification';
    public const LOGIN_VERIFICATION = 'api/login_verification';
    public const TELESCOPE = 'telescope';
    public const LOG_VIEWER = 'log-viewer';
    public const WELCOME = 'welcome';
    public const BASE = '/';
    public const DEBUGBAR_PREFIX = '_debugbar/';
    public const TELESCOPE_PREFIX = 'telescope/';
    public const LOG_VIEWER_PREFIX = 'log-viewer/';
}

