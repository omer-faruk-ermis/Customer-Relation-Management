<?php

namespace App\Filters\WebUser;

use App\Filters\AbstractFilter;

class WebUserFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'agreement_state'       => AgreementState::class,
            'corporation_name'      => CorporationName::class,
            'full_name'             => FullName::class,
            'identity_no'           => IdentityNo::class,
            'tax_identification_no' => TaxIdentificationNo::class,
            'phone'                 => Phone::class,
            'subscriber_no'         => SubscriberNo::class,
            'user_name'             => UserName::class,
            'user_type'             => UserType::class,
            'sim_card'              => SimCard::class,
            'search_location'       => SearchLocation::class
        ];
    }
}
