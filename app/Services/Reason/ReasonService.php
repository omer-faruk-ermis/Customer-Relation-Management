<?php

namespace App\Services\Reason;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Models\Sebep\Sebepler;
use App\Services\AbstractService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class ReasonService
 *
 * @package App\Service\Reason
 */
class ReasonService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::DEFINE_REASON
        ],
    ];

    /**
     * @param Request  $request
     *
     * @return Collection
     * @throws Exception
     */
    public function index(Request $request): Collection
    {
        return Sebepler::limit(DefaultConstant::SEARCH_LIST_LIMIT)->get();
    }
}
