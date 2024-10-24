<?php

namespace App\Services\Authorization;

use App\Enums\Method;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\Authorization\EmployeeAuthorizationNotFoundException;
use App\Exceptions\Authorization\EmployeeWebUserTypeAuthorizationAlreadyHaveException;
use App\Exceptions\Authorization\EmployeeWebUserTypeAuthorizationNotFoundException;
use App\Helpers\CacheOperation;
use App\Models\Authorization\SmsKimlikWebUserTipYetki;
use App\Models\Operator\OperatorTanimlari;
use App\Models\WebUser\WebUserKullaniciTipleri;
use App\Services\AbstractService;
use App\Services\BulkAuthorizationTrait;
use App\Utils\DateUtil;
use App\Utils\RouteUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class EmployeeWebUserTypeAuthorizationService
 *
 * @package App\Service\Authorization
 */
class EmployeeWebUserTypeAuthorizationService extends AbstractService
{
    use BulkAuthorizationTrait;

    /**
     * @param Request  $request
     *
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $employeeWebUserTypeAuthorizationModel = SmsKimlikWebUserTipYetki::getModel();
        $operatorDefineModel = OperatorTanimlari::getModel();
        $webUserTypeModel = WebUserKullaniciTipleri::getModel();

        return SmsKimlikWebUserTipYetki::with('recorder')
                                       ->join(
                                           $operatorDefineModel->getTable(),
                                           $employeeWebUserTypeAuthorizationModel->qualifyColumn('kopkodu'),
                                           '=',
                                           $operatorDefineModel->qualifyColumn('op_kodu'))
                                       ->join(
                                           $webUserTypeModel->getTable(),
                                           $employeeWebUserTypeAuthorizationModel->qualifyColumn('webuser_tip'),
                                           '=',
                                           $webUserTypeModel->qualifyColumn('ktip'))
                                       ->where('sms_kimlik', '=', $request->input('employee_id'))
                                       ->where($operatorDefineModel->qualifyColumn('abonecdrbildir'), NumericalConstant::TRUE)
                                       ->active()
                                       ->get();
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function store(Request $request): void
    {
        $employeeWebUserTypeAuthorizationPermission = SmsKimlikWebUserTipYetki::where('sms_kimlik', '=', $request->input('employee_id'))
                                                                              ->where('webuser_tip', '=', $request->input('web_user_type'))
                                                                              ->where('kopkodu', '=', $request->input('operator_code'))
                                                                              ->active()
                                                                              ->first();

        if ($employeeWebUserTypeAuthorizationPermission) {
            throw new EmployeeWebUserTypeAuthorizationAlreadyHaveException();
        }

        SmsKimlikWebUserTipYetki::create([
                                             'sms_kimlik'  => $request->input('employee_id'),
                                             'webuser_tip' => $request->input('web_user_type'),
                                             'kopkodu'     => $request->input('operator_code'),

                                             'kayit_id'    => Auth::id(),
                                             'kayit_ip'    => $request->ip(),
                                             'kayit_tarih' => DateUtil::now(),

                                             'durum' => Status::ACTIVE,
                                         ]);

        if (Method::STORE === RouteUtil::currentRoute())
            CacheOperation::refreshEmployeeSession($request->bearerToken());
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws EmployeeAuthorizationNotFoundException
     * @throws Exception
     */
    public function destroy(Request $request): void
    {
        $employeeWebUserTypeAuthorizationPermission = SmsKimlikWebUserTipYetki::where('webuser_tip', '=', $request->input('web_user_type'))
                                                                              ->where('sms_kimlik', '=', $request->input('employee_id'))
                                                                              ->where('kopkodu', '=', $request->input('operator_code'))
                                                                              ->when(Method::DESTROY === RouteUtil::currentRoute(), function ($q) {
                                                                                  $q->active();
                                                                              })
                                                                              ->first();

        if (empty($employeeWebUserTypeAuthorizationPermission)) {
            throw new EmployeeWebUserTypeAuthorizationNotFoundException();
        }

        $employeeWebUserTypeAuthorizationPermission->durum = Status::PASSIVE;
        $employeeWebUserTypeAuthorizationPermission->update();

        if (Method::DESTROY === RouteUtil::currentRoute())
            CacheOperation::refreshEmployeeSession($request->bearerToken());
    }
}
