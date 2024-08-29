<?php

namespace App\Services\Staff;

use App\Enums\Method;
use App\Enums\Status;
use App\Exceptions\Staff\StaffGroupAuthorizationMatchNotFoundException;
use App\Helpers\CacheOperation;
use App\Models\Staff\PersonelGrupYetkiEslestir;
use App\Services\AbstractService;
use App\Services\BulkAuthorizationTrait;
use App\Utils\DateUtil;
use App\Utils\RouteUtil;
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
    use BulkAuthorizationTrait;

    /**
     * @param Request  $request
     *
     * @return void
     *
     * @throws Exception
     */
    public function store(Request $request): void
    {
        $staffGroupAuthorizationMatch =
            PersonelGrupYetkiEslestir::where('personel_grup_id', '=', $request->input('staff_group_id'))
                                     ->where('yetki_id', '=', $request->input('authorization_id'))
                                     ->where('tip', '=', $request->input('type'))
                                     ->active()
                                     ->first();

        if ($staffGroupAuthorizationMatch) {
            throw new StaffGroupAuthorizationMatchNotFoundException();
        }

        PersonelGrupYetkiEslestir::create([
                                              'personel_grup_id' => $request->input('staff_group_id'),
                                              'yetki_id'         => $request->input('authorization_id'),
                                              'durum'            => Status::ACTIVE,
                                              'tip'              => $request->input('type'),

                                              'kayit_tarihi'     => DateUtil::now(),
                                              'sms_kimlik'       => Auth::id(),
                                          ]);


        if (Method::STORE === RouteUtil::currentRoute())
            CacheOperation::setSession($request);
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws StaffGroupAuthorizationMatchNotFoundException
     * @throws Exception
     */
    public function destroy(Request $request): void
    {
        $staffGroupAuthorizationMatch =
            PersonelGrupYetkiEslestir::where('personel_grup_id', '=', $request->input('staff_group_id'))
                                     ->where('yetki_id', '=', $request->input('authorization_id'))
                                     ->where('tip', '=', $request->input('type'))
                                     ->when(Method::DESTROY === RouteUtil::currentRoute(), function ($q) {
                                         $q->active();
                                     })
                                     ->first();

        if (empty($staffGroupAuthorizationMatch)) {
            throw new StaffGroupAuthorizationMatchNotFoundException();
        }

        $staffGroupAuthorizationMatch->durum = Status::PASSIVE;
        $staffGroupAuthorizationMatch->update();

        if (Method::DESTROY === RouteUtil::currentRoute())
            CacheOperation::setSession($this->request);
    }
}
