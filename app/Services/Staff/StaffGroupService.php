<?php

namespace App\Services\Staff;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\Staff\StaffGroupNotFoundException;
use App\Http\Requests\Staff\StoreStaffGroupRequest;
use App\Http\Requests\Staff\UpdateStaffGroupRequest;
use App\Models\Staff\PersonelGruplari;
use App\Services\AbstractService;
use App\Utils\Security;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class StaffGroupService
 *
 * @package App\Service\Staff
 */
class StaffGroupService extends AbstractService
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
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return PersonelGruplari::with([
                                          'recorder',
                                          'members.recorder',
                                          'members.staff',
                                          'authorizations.smsManagement.recorder',
                                          'authorizations.blueScreen.recorder',
                                          'authorizations.authorization.recorder',
                                          'authorizations.subscriberBillet.recorder'
                                      ])
                               ->where('durum', '<>', Status::DESTROY)
                               ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param StoreStaffGroupRequest  $request
     *
     * @return PersonelGruplari
     */
    public function store(StoreStaffGroupRequest $request): PersonelGruplari
    {
        return PersonelGruplari::create([
                                            'grup_adi'     => $request->input('name'),
                                            'durum'        => $request->input('state'),
                                            'aciklama'     => $request->input('description'),
                                            'sms_kimlik'   => Auth::id(),
                                            'kayit_tarihi' => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT)
                                        ]);
    }

    /**
     * @param UpdateStaffGroupRequest  $request
     * @param string                   $id
     *
     * @return PersonelGruplari
     * @throws StaffGroupNotFoundException
     */
    public function update(UpdateStaffGroupRequest $request, string $id): PersonelGruplari
    {
        $staffGroup = PersonelGruplari::find(Security::decrypt($id));
        if (empty($staffGroup)) {
            throw new StaffGroupNotFoundException();
        }

        $staffGroup->update([
                                'grup_adi' => $request->input('name'),
                                'durum'    => $request->input('state'),
                                'aciklama' => $request->input('description'),
                            ]);

        return $staffGroup;
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws StaffGroupNotFoundException
     */
    public function destroy(string $id): void
    {
        $staffGroup = PersonelGruplari::find(Security::decrypt($id));
        if (empty($staffGroup)) {
            throw new StaffGroupNotFoundException();
        }

        $staffGroup->durum = Status::DESTROY;
        $staffGroup->update();
    }
}
