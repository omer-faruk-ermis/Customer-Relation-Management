<?php

namespace App\Services\Staff;

use App\Enums\Method;
use App\Enums\Status;
use App\Exceptions\Staff\StaffGroupMatchAlreadyHaveException;
use App\Exceptions\Staff\StaffGroupMatchNotFoundException;
use App\Helpers\CacheOperation;
use App\Http\Requests\Authorization\BulkEmployeeAuthorizationRequest;
use App\Models\Staff\PersonelGrupEslestir;
use App\Services\AbstractService;
use App\Services\BulkAuthorizationTrait;
use App\Utils\DateUtil;
use App\Utils\RouteUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class StaffGroupMatchService
 *
 * @package App\Service\Staff
 */
class StaffGroupMatchService extends AbstractService
{
    use BulkAuthorizationTrait;

    /**
     * @param Request  $request
     *
     * @return PersonelGrupEslestir
     * @throws StaffGroupMatchAlreadyHaveException
     * @throws Exception
     */
    public function store(Request $request): PersonelGrupEslestir
    {
        $staffGroupMatch = PersonelGrupEslestir::where('personel_grup_id', '=', $request->input('staff_group_id'))
                                               ->where('personel_id', '=', $request->input('staff_id'))
                                               ->first();

        if ($staffGroupMatch && $staffGroupMatch->durum == Status::ACTIVE) {
            if (Method::STORE === RouteUtil::currentRoute()) {
                throw new StaffGroupMatchAlreadyHaveException();
            } else {
                return $staffGroupMatch;
            }
        }

        if ($staffGroupMatch && $staffGroupMatch->durum != Status::ACTIVE) {
            $staffGroupMatch->durum = Status::ACTIVE;
            $staffGroupMatch->update();
            return $staffGroupMatch;
        }

        $staffGroupMatchData = PersonelGrupEslestir::create([
                                         'personel_grup_id' => $request->input('staff_group_id'),
                                         'personel_id'      => $request->input('staff_id'),
                                         'durum'            => Status::ACTIVE,

                                         'kayit_tarihi'     => DateUtil::now(),
                                         'sms_kimlik'       => Auth::id(),
                                     ]);

        if (Method::STORE === RouteUtil::currentRoute())
            CacheOperation::refreshEmployeeSession($request->bearerToken());

        return $staffGroupMatchData;
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws StaffGroupMatchNotFoundException
     * @throws Exception
     */
    public function destroyStaff(string $id): void
    {
        $staffGroupMatch = PersonelGrupEslestir::find($id);
        if (empty($staffGroupMatch)) {
            throw new StaffGroupMatchNotFoundException();
        }

        $staffGroupMatch->durum = Status::PASSIVE;
        $staffGroupMatch->update();

        CacheOperation::refreshEmployeeSession($this->request->bearerToken());
    }

    /**
     * @param BulkEmployeeAuthorizationRequest  $request
     *
     * @return void
     * @throws Exception
     * @throws StaffGroupMatchNotFoundException
     */
    public function destroy(Request $request): void
    {
        $staffGroupMatch = PersonelGrupEslestir::where('personel_grup_id', '=', $request->input('staff_group_id'))
                                               ->where('personel_id', '=', $request->input('staff_id'))
                                               ->first();

        if (empty($staffGroupMatch)) {
            throw new StaffGroupMatchNotFoundException();
        }

        $staffGroupMatch->durum = Status::PASSIVE;
        $staffGroupMatch->update();
    }
}
