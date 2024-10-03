<?php

namespace App\Filters\Subscriber;

use App\Filters\AbstractFilter;
use App\Filters\Url\Name;
use App\Filters\Url\Search;
use App\Filters\Url\Url;

class VipSpecialCustomerFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'type'          => Type::class,
            'web_user_id'   => WebUser::class,
            'sip'           => Sip::class,
            'description'   => Description::class,
            'subscriber_no' => SubscriberNo::class,
            'phone'         => Phone::class,
        ];
    }
}
