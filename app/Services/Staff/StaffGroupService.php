<?php

namespace App\Services\Staff;

use App\Enums\Authorization\AuthorizationType;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\Staff\StaffGroupNotFoundException;
use App\Models\Staff\PersonelGruplari;
use App\Models\Staff\PersonelGrupYetkiEslestir;
use App\Services\AbstractService;
use App\Services\Authorization\AuthorizationService;
use App\Utils\DateUtil;
use App\Utils\Security;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class StaffGroupService
 *
 * @package App\Service\Staff
 */
class StaffGroupService extends AbstractService
{
    private const AUTHORIZATION_TYPES = [
        'smsManagement'    => AuthorizationType::SMS_MANAGEMENT,
        'blueScreen'       => AuthorizationType::BLUE_SCREEN,
        'authorization'    => AuthorizationType::AUTHORIZATION,
        'subscriberBillet' => AuthorizationType::SUBSCRIBER_BILLET,
    ];

    /**
     * @param Request  $request
     *
     * @return Collection|LengthAwarePaginator
     */
    public function index(Request $request): Collection|LengthAwarePaginator
    {
        $groups = PersonelGruplari::with([
                                             'recorder',
                                             'members.recorder',
                                             'members.staff',
                                             'authorizations.smsManagement.recorder',
                                             'authorizations.blueScreen.recorder',
                                             'authorizations.authorization.recorder',
                                             'authorizations.subscriberBillet.recorder'
                                         ])
                                  ->filter($request->all())
                                  ->where('durum', '<>', Status::DESTROY);

        return $request->input('page')
            ? $groups->paginate(DefaultConstant::PAGINATE)
            : $groups->get();
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
        $staffGroup = PersonelGruplari::with([
                                                 'recorder',
                                                 'members.recorder'
                                             ])
                                      ->where('durum', '<>', Status::DESTROY)
                                      ->find(Security::decrypt($id));
        if (empty($staffGroup)) {
            throw new StaffGroupNotFoundException();
        }

        $authorizationService = new AuthorizationService(Auth::id());
        $authorizations = [];
        $authorizationIds = [];

        foreach (self::AUTHORIZATION_TYPES as $type => $value) {
            $groupAuthorizations = $authorizationService->authorizationGroup($value, Security::decrypt($id));

            $authorizationIds[$type] = !empty($groupAuthorizations)
                ? $authorizationService->$type($groupAuthorizations)->pluck('id')->toArray()
                : [];

            $authorizations[$type] = $authorizationService->$type([], true);

            foreach ($authorizations[$type] as $key => $authorization) {
                $matching = PersonelGrupYetkiEslestir::with('recorder')
                                                     ->where('personel_grup_id', Security::decrypt($id))
                                                     ->where('yetki_id', '=', $authorization['id'])
                                                     ->where('tip', '=', $value)
                                                     ->where('durum', '=', Status::ACTIVE)
                                                     ->first();

                $authorizations[$type][$key]->is_authorized = !empty($matching);

                if (!empty($matching)) {
                    $authorizations[$type][$key]->match_id = $matching->id;
                    $authorizations[$type][$key]->staff_group_id = $matching['personel_grup_id'];
                    $authorizations[$type][$key]->match_state = $matching->durum;
                    $authorizations[$type][$key]->match_type = $matching->tip;
                    $authorizations[$type][$key]->recorder = $matching->recorder;
                }
            }
        }

        $staffGroup['authorizationCollect'] = (object)$authorizations;

        return $staffGroup;
    }

    /**
     * @param Request  $request
     *
     * @return PersonelGruplari
     */
    public function store(Request $request): PersonelGruplari
    {
        return PersonelGruplari::create([
                                            'grup_adi' => $request->input('name'),
                                            'durum'    => $request->input('state'),
                                            'aciklama' => $request->input('description'),

                                            'sms_kimlik'   => Auth::id(),
                                            'kayit_tarihi' => DateUtil::now(),
                                        ]);
    }

    /**
     * @param Request  $request
     * @param string   $id
     *
     * @return PersonelGruplari
     * @throws StaffGroupNotFoundException
     */
    public function update(Request $request, string $id): PersonelGruplari
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
