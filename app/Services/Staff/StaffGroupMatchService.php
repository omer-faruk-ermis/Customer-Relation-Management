<?php

namespace App\Services\Staff;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\Staff\StaffGroupMatchNotFoundException;
use App\Models\Staff\PersonelGrupEslestir;
use App\Services\AbstractService;
use App\Utils\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Class StaffGroupMatchService
 *
 * @package App\Service\Staff
 */
class StaffGroupMatchService extends AbstractService
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
     * @return PersonelGrupEslestir
     */
    public function store(Request $request): PersonelGrupEslestir
    {
        return PersonelGrupEslestir::create([
                                                'personel_grup_id' => $request->input('staff_group_id'),
                                                'personel_id'      => $request->input('staff_id'),
                                                'durum'            => Status::ACTIVE,
                                                'kayit_tarihi'     => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
                                                'sms_kimlik'       => Auth::id(),
                                            ]);
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws StaffGroupMatchNotFoundException
     */
    public function destroy(string $id): void
    {
        $staffGroupMatch = PersonelGrupEslestir::find(Security::decrypt($id));
        if (empty($staffGroupMatch)) {
            throw new StaffGroupMatchNotFoundException();
        }

        $staffGroupMatch->durum = Status::PASSIVE;
        $staffGroupMatch->update();
    }
}
