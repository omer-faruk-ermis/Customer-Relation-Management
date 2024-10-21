<?php

namespace App\Filters\WebUser;

use App\Enums\AgreementType;

class AgreementState
{
    public function apply($query, $value): void
    {
        $query
            ->when(AgreementType::ACTIVE == $value, function ($q) use ($value) {
                return $q->where('sozlesme', '=', AgreementType::ACTIVE);
            })
            ->when(AgreementType::MEMBER == $value, function ($q) use ($value) {
                return $q->where('sozlesme', '=', AgreementType::PASSIVE)
                         ->whereNull('sozlesme_tarih');
            })
            ->when(AgreementType::PASSIVE == $value, function ($q) use ($value) {
                return $q->where('sozlesme', '=', AgreementType::PASSIVE)
                         ->whereNotNull('sozlesme_tarih');
            });
    }
}
