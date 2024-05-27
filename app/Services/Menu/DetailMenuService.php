<?php

namespace App\Services\Menu;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Models\Menu\DetayMenu;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class DetailMenuService
 *
 * @package App\Service\Menu
 */
class DetailMenuService extends AbstractService
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
        return DetayMenu::with([
                                   'pages',
                                   'members'
                               ])
                        ->where('durum', '=', Status::ACTIVE)
                        ->where('parentid', '=', NumericalConstant::ZERO)
                        ->orderBy('sira')
                        ->get();
    }

    /**
     * @param Request  $request
     *
     * @return Collection
     *
     */
    public function page(Request $request): Collection
    {
        return DetayMenu::with(['members'])
                        ->where('durum', '=', Status::ACTIVE)
                        ->where('parentid', '<>', NumericalConstant::ZERO)
                        ->orderBy('sira')
                        ->get();
    }
}
