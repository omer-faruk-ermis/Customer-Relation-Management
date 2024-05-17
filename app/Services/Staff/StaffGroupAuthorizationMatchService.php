<?php

namespace App\Services\Staff;

use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\Staff\StaffGroupAuthorizationMatchNotFoundException;
use App\Models\Staff\PersonelGrupYetkiEslestir;
use App\Utils\Security;
use Illuminate\Http\Request;

/**
 * Class StaffGroupAuthorizationMatchService
 *
 * @package App\Service\Staff
 */
class StaffGroupAuthorizationMatchService
{
    /**
     * @param Request  $request
     *
     * @return PersonelGrupYetkiEslestir
     */
    public function store(Request $request): PersonelGrupYetkiEslestir
    {
        return PersonelGrupYetkiEslestir::create([
                                                     'personel_grup_id' => $request->input('staff_group_id'),
                                                     'yetki_id'         => $request->input('authorization_id'),
                                                     'durum'            => Status::ACTIVE,
                                                     'tip'              => $request->input('type'),
                                                     'kayit_tarihi'     => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
                                                     'sms_kimlik'       => $request->input('employee_id'),
                                                 ]);
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws StaffGroupAuthorizationMatchNotFoundException
     */
    public function destroy(string $id): void
    {
        $staffGroupAuthorizationMatch = PersonelGrupYetkiEslestir::find(Security::decrypt($id));
        if (empty($staffGroupAuthorizationMatch)) {
            throw new StaffGroupAuthorizationMatchNotFoundException();
        }

        $staffGroupAuthorizationMatch->durum = Status::PASSIVE;
        $staffGroupAuthorizationMatch->update();
    }
}
