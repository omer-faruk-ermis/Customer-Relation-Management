<?php

namespace App\Services\Subject;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Models\Subject\KonuBilgiKullanimYeri;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class SubjectInformationUsePlaceService
 *
 * @package App\Service\Subject
 */
class SubjectInformationUsePlaceService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::AUTHORIZED_GROUPS,
            SmsManagement::AUTHORIZED_GROUPS_GROUP,
            SmsManagement::APP_MANAGEMENT,
            SmsManagement::APP_EMPLOYEE
        ]
    ];

    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return KonuBilgiKullanimYeri::active()->get();
    }
}
