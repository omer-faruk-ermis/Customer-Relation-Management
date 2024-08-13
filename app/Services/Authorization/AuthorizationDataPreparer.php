<?php

namespace App\Services\Authorization;

use App\Enums\Authorization\AuthorizationType;
use App\Enums\Authorization\AuthorizationUserType;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\ForbiddenException;
use App\Exceptions\Staff\StaffGroupMatchAlreadyHaveException;
use App\Models\Authorization\SmsKimlikWebUserTipYetki;
use App\Models\Authorization\SmsKimlikYetki;
use App\Models\Menu\DetayMenuUser;
use App\Models\Staff\PersonelGrupEslestir;
use App\Models\Staff\PersonelGruplari;
use App\Models\WebPortal\WebPortalYetkiIzin;
use App\Services\Staff\StaffGroupAuthorizationMatchService;
use App\Services\Staff\StaffGroupMatchService;
use App\Services\Staff\StaffGroupService;
use App\Utils\DateUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthorizationDataPreparer
 *
 * @package App\Service\Authorization
 */
class AuthorizationDataPreparer
{
    /**
     * @param array    $authorization
     * @param string   $receiverId
     * @param Request  $request
     *
     * @return void
     */
    public function prepareSmsManagement(array $authorization, string $receiverId, Request $request): void
    {
        SmsKimlikYetki::where('sms_kimlik', $receiverId)->update(['durum' => Status::PASSIVE]);

        $data = [];
        foreach ($authorization as $smsManagement) {
            $data[] = [
                'sms_kimlik' => $receiverId,
                'url_id'     => $smsManagement,
                'durum'      => Status::ACTIVE,
                'kayit_id'   => Auth::id(),
                'kayit_ip'   => $request->ip(),
            ];
        }

        SmsKimlikYetki::insert($data);
    }

    /**
     * @param array    $authorization
     * @param string   $receiverId
     * @param Request  $request
     *
     * @return void
     */
    public function prepareBlueScreen(array $authorization, string $receiverId, Request $request): void
    {
        DetayMenuUser::where('userid', $receiverId)->update(['durum' => Status::PASSIVE]);

        $data = [];
        foreach ($authorization as $blueScreen) {
            $data[] = [
                'userid'    => $receiverId,
                'menu_id'   => $blueScreen,
                'durum'     => Status::ACTIVE,
                'kayit_id'  => Auth::id(),
                'kayit_ip'  => $request->ip(),
                'kayit_tar' => DateUtil::now(),
            ];
        }

        DetayMenuUser::insert($data);
    }

    /**
     * @param array   $authorization
     * @param string  $receiverId
     *
     * @return void
     */
    public function prepareAuthorization(array $authorization, string $receiverId): void
    {
        WebPortalYetkiIzin::where('userid', $receiverId)->update(['durum' => Status::PASSIVE]);

        $data = [];
        foreach ($authorization as $auth) {
            $data[] = [
                'userid'   => $receiverId,
                'yetki_id' => $auth,
                'usermi'   => AuthorizationUserType::AGENT,
                'durum'    => Status::ACTIVE,
                'tarih'    => DateUtil::now(),
            ];
        }

        WebPortalYetkiIzin::insert($data);
    }

    /**
     * @param          $authorization
     * @param string   $receiverId
     * @param Request  $request
     *
     * @return void
     */
    public function prepareUserAuthorization($authorization, string $receiverId, Request $request): void
    {
        SmsKimlikWebUserTipYetki::where('sms_kimlik', $receiverId)->update(['durum' => Status::PASSIVE]);

        $userAuthorizations = SmsKimlikWebUserTipYetki::whereIn('id', $authorization)->get();

        $data = [];
        foreach ($userAuthorizations as $userAuthorization) {
            $data[] = [
                'sms_kimlik'  => $receiverId,
                'webuser_tip' => $userAuthorization->webuser_tip,
                'kopkodu'     => $userAuthorization->kopkodu,
                'kayit_id'    => Auth::id(),
                'kayit_ip'    => $request->ip(),
                'kayit_tarih' => DateUtil::now(),
                'durum'       => Status::ACTIVE,
            ];
        }

        SmsKimlikWebUserTipYetki::insert($data);
    }

    /**
     * @param string  $receiverId
     *
     * @return void
     */
    public function clearGroup(string $receiverId): void
    {
        PersonelGrupEslestir::where('personel_id', $receiverId)->update(['durum' => Status::PASSIVE]);
    }

    /**
     * @param          $authorization
     * @param string   $receiverId
     * @param Request  $request
     *
     * @return void
     * @throws ForbiddenException
     * @throws StaffGroupMatchAlreadyHaveException
     */
    public function prepareSubscriberBillet($authorization, string $receiverId, Request $request): void
    {
        $staffGroup = $this->createStaffGroup($request);
        $this->matchStaffToGroup($staffGroup->id, $receiverId, $request);
        $this->matchAuthorizationToGroup($staffGroup->id, $authorization, $request);
    }

    /**
     * @param Request  $request
     *
     * @return PersonelGruplari
     * @throws ForbiddenException
     */
    public function createStaffGroup(Request $request): PersonelGruplari
    {
        return (new StaffGroupService($request))->store(new Request([
                                                                        'name'  => DefaultConstant::AUTHORIZATION_GROUP,
                                                                        'state' => Status::ACTIVE,
                                                                    ]));
    }

    /**
     * @param int      $staffGroupId
     * @param string   $receiverId
     * @param Request  $request
     *
     * @return PersonelGrupEslestir
     * @throws ForbiddenException
     * @throws StaffGroupMatchAlreadyHaveException
     */
    public function matchStaffToGroup(int $staffGroupId, string $receiverId, Request $request): PersonelGrupEslestir
    {
        return (new StaffGroupMatchService($request))->store(new Request([
                                                                             'staff_group_id' => $staffGroupId,
                                                                             'staff_id'       => $receiverId,
                                                                             'state'          => Status::ACTIVE,
                                                                         ]));
    }

    /**
     * @param int      $staffGroupId
     * @param array    $authorizationIds
     * @param Request  $request
     *
     * @return void
     * @throws ForbiddenException
     * @throws Exception
     */
    public function matchAuthorizationToGroup(int $staffGroupId, array $authorizationIds, Request $request): void
    {
        foreach ($authorizationIds as $authorizationId) {
            (new StaffGroupAuthorizationMatchService($request))->store(new Request([
                                                                                       'staff_group_id'   => $staffGroupId,
                                                                                       'authorization_id' => $authorizationId,
                                                                                       'type'             => AuthorizationType::SUBSCRIBER_BILLET,
                                                                                   ]));
        }
    }
}
