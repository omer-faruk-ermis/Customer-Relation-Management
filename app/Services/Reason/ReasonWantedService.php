<?php

namespace App\Services\Reason;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Models\Sebep\SebepIstenecekler;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class ReasonWantedService
 *
 * @package App\Service\Reason
 */
class ReasonWantedService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::DEFINE_REASON
        ],
    ];

    /**
     * @param Request $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return SebepIstenecekler::limit(DefaultConstant::SEARCH_LIST_LIMIT)->get();
    }
}
