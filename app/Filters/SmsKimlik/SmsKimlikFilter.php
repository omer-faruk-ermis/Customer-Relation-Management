<?php

namespace App\Filters\SmsKimlik;

use App\Filters\AbstractFilter;

class SmsKimlikFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'full_name'        => FullName::class,
            'password'         => Password::class,
            'login_permission' => LoginPermission::class,
            'sip'              => Sip::class,
            'unit'             => Unit::class,
            'currency_limit'   => CurrencyLimit::class,
            'mobile_phone'     => MobilePhone::class,
            'email'            => Email::class,
            'username'         => Username::class,
            'email_password'   => EmailPassword::class,
            'home_phone'       => HomePhone::class,
        ];
    }
}
