<?php

namespace App\Services\Staff;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\Staff\StaffGroupAuthorizationMatchNotFoundException;
use App\Helpers\CacheOperation;
use App\Models\Staff\PersonelGrupYetkiEslestir;
use App\Services\AbstractService;
use App\Utils\Security;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class StaffGroupAuthorizationMatchService
 *
 * @package App\Service\Staff
 */
class StaffGroupAuthorizationMatchService extends AbstractService
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
     * @return PersonelGrupYetkiEslestir
     *
     * @throws Exception
     */
    public function store(Request $request): PersonelGrupYetkiEslestir
    {
        $employeeGroupAuthorizationMatch = PersonelGrupYetkiEslestir::create([
                                                                                 'personel_grup_id' => $request->input('staff_group_id'),
                                                                                 'yetki_id'         => $request->input('authorization_id'),
                                                                                 'durum'            => Status::ACTIVE,
                                                                                 'tip'              => $request->input('type'),
                                                                                 'kayit_tarihi'     => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
                                                                                 'sms_kimlik'       => Auth::id(),
                                                                             ]);

        CacheOperation::setSession($request);

        return $employeeGroupAuthorizationMatch;
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws StaffGroupAuthorizationMatchNotFoundException
     *
     * @throws Exception
     */
    public function destroy(string $id): void
    {
        $staffGroupAuthorizationMatch = PersonelGrupYetkiEslestir::find(Security::decrypt($id));
        if (empty($staffGroupAuthorizationMatch)) {
            throw new StaffGroupAuthorizationMatchNotFoundException();
        }

        $staffGroupAuthorizationMatch->durum = Status::PASSIVE;
        $staffGroupAuthorizationMatch->update();

        CacheOperation::setSession($this->request);
    }
}
