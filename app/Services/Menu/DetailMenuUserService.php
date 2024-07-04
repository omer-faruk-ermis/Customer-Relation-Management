<?php

namespace App\Services\Menu;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\DetailMenu\DetailMenuUserNotFoundException;
use App\Helpers\CacheOperation;
use App\Models\Menu\DetayMenuUser;
use App\Services\AbstractService;
use App\Utils\Security;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class DetayMenuUserService
 *
 * @package App\Service\Menu
 */
class DetailMenuUserService extends AbstractService
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
     * @return void
     * @throws Exception
     */
    public function store(Request $request): void
    {
        DetayMenuUser::create([
                                  'menu_id'   => $request->input('menu_id'),
                                  'userid'    => $request->input('employee_id'),
                                  'kayit_tar' => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
                                  'kayit_id'  => Auth::id(),
                                  'kayit_ip'  => $request->ip(),
                                  'durum'     => Status::ACTIVE,
                              ]);

        CacheOperation::setSession($request);
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws DetailMenuUserNotFoundException
     * @throws Exception
     */
    public function destroy(string $id): void
    {
        $detailMenuUser = DetayMenuUser::find(Security::decrypt($id));
        if (empty($detailMenuUser)) {
            throw new DetailMenuUserNotFoundException();
        }

        $detailMenuUser->durum = Status::PASSIVE;
        $detailMenuUser->update();

        CacheOperation::setSession($this->request);
    }
}
