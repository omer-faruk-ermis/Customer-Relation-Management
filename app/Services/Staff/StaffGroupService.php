<?php

namespace App\Services\Staff;

use App\Enums\Authorization\AuthorizationType;
use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\Staff\StaffGroupNotFoundException;
use App\Http\Requests\Staff\StoreStaffGroupRequest;
use App\Http\Requests\Staff\UpdateStaffGroupRequest;
use App\Models\Staff\PersonelGruplari;
use App\Models\Staff\PersonelGrupYetkiEslestir;
use App\Services\AbstractService;
use App\Services\Authorization\AuthorizationService;
use App\Utils\Security;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
     * @param Request  $request
     * @param string   $id
     *
     * @return Model
     * @throws StaffGroupNotFoundException
     */
    public function show(Request $request, string $id): Model
    {
        $staffGroup = PersonelGruplari::with(['recorder', 'members'])->find(Security::decrypt($id));
        if (empty($staffGroup)) {
            throw new StaffGroupNotFoundException();
        }

        $authorizationService = new AuthorizationService(Auth::id());
        $authorizationTypes = [
            'smsManagement'    => AuthorizationType::SMS_MANAGEMENT,
            'blueScreen'       => AuthorizationType::BLUE_SCREEN,
            'authorization'    => AuthorizationType::AUTHORIZATION,
            'subscriberBillet' => AuthorizationType::SUBSCRIBER_BILLET,
        ];

        $authorizations = [];
        foreach ($authorizationTypes as $type => $value) {
            $groupAuthorizations = $authorizationService->authorizationGroup($value, Security::decrypt($id));

            $authorizations[$type] = !empty($groupAuthorizations)
                ? $authorizationService->$type($groupAuthorizations)
                : collect();

            foreach ($authorizations[$type] as $key => $authorization) {
                $matching = PersonelGrupYetkiEslestir::with('recorder')
                                                     ->where('personel_grup_id', Security::decrypt($id))
                                                     ->where('yetki_id', '=', $authorization['id'])
                                                     ->where('tip', '=', $value)
                                                     ->first();

                if (!empty($matching)) {
                    $authorizations[$type][$key]->match_id = $matching->id;
                    $authorizations[$type][$key]->staff_group_id = $matching['personel_grup_id'];
                    $authorizations[$type][$key]->match_state = $matching->durum;
                    $authorizations[$type][$key]->match_type = $matching->tip;
                    $authorizations[$type][$key]->recorder = $matching->recorder;
                }
            }
        }

        $staffGroup['authorizationCollect'] = (object) $authorizations;

        return $staffGroup;
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
