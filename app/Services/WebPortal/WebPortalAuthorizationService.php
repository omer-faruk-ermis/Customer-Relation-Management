<?php

namespace App\Services\WebPortal;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Models\WebPortal\WebPortalYetki;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class WebPortalAuthorizationService
 *
 * @package App\Service\WebPortal
 */
class WebPortalAuthorizationService extends AbstractService
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
    public function menu(Request $request): Collection
    {
        return WebPortalYetki::with('members')
                             ->active()
                             ->whereNotNull('yetki_detay')
                             ->whereNotNull('menu_id')
                             ->whereNotNull('tip')
                             ->get()
                             ->groupBy('tanim');
    }

    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function page(Request $request): Collection
    {
        return WebPortalYetki::with('members')
                             ->active()
                             ->whereNotNull('yetki_detay')
                             ->whereNotNull('menu_id')
                             ->whereNotNull('tip')
                             ->get();
    }
}
