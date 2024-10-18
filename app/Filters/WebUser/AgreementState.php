<?php

namespace App\Filters\WebUser;

use App\Enums\AgreementType;

class AgreementState
{
    public function apply($query, $value): void
    {
        $query
            ->when(AgreementType::ACTIVE === $value, function ($q) use ($value) {
                return $q->where('sozlesme', '=', $value);
            })
            ->when(AgreementType::PASSIVE === $value, function ($q) use ($value) {
                return $q->where('sozlesme', '=', $value)
                         ->whereNotNull('sozlesme_tarih');
            })
            ->when(AgreementType::MEMBER === $value, function ($q) use ($value) {
                return $q->where('sozlesme', '=', $value)
                         ->whereNull('sozlesme_tarih');
            });
    }
}
