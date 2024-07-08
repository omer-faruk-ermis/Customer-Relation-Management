<?php

namespace App\Services\Authorization;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\AuthorizationTypeTrName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\Status;
use App\Models\Authorization\AboneKutukYetkileri;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class SubscriberBilletAuthorizationService
 *
 * @package App\Service\Authorization
 */
class SubscriberBilletAuthorizationService extends AbstractService
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
     * @return object
     */
    public function menu(Request $request): object
    {
        return (object)[
            'name'  => AuthorizationTypeTrName::SUBSCRIBER_BILLET,
            'pages' => AboneKutukYetkileri::where('durum', '=', Status::ACTIVE)->get()];
    }

    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function page(Request $request): Collection
    {
        return AboneKutukYetkileri::with('menu')->where('durum', '=', Status::ACTIVE)->get();
    }
}
