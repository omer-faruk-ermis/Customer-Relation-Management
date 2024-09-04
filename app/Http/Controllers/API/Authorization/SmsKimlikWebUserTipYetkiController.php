<?php

namespace App\Http\Controllers\API\Authorization;

use App\Exceptions\Authorization\EmployeeAuthorizationNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\BulkEmployeeWebUserTypeAuthorizationRequest;
use App\Http\Requests\Authorization\DestroyEmployeeWebUserTypeAuthorizationRequest;
use App\Http\Requests\Authorization\IndexEmployeeWebUserTypeAuthorizationRequest;
use App\Http\Requests\Authorization\StoreEmployeeWebUserTypeAuthorizationRequest;
use App\Http\Resources\Authorization\EmployeeWebUserTypeAuthorizationCollection;
use App\Http\Resources\SuccessResource;
use App\Services\Authorization\EmployeeWebUserTypeAuthorizationService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class SmsKimlikWebUserTipYetkiController
 *
 * @package App\Http\Controllers\API\Authorization
 */
class SmsKimlikWebUserTipYetkiController extends Controller
{
    /** @var EmployeeWebUserTypeAuthorizationService $employeeWebUserTypeAuthorizationService */
    private EmployeeWebUserTypeAuthorizationService $employeeWebUserTypeAuthorizationService;

    /**
     * SmsKimlikWebUserTipYetkiController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->employeeWebUserTypeAuthorizationService = new EmployeeWebUserTypeAuthorizationService($request);
    }

    /**
     * @param IndexEmployeeWebUserTypeAuthorizationRequest  $request
     *
     * @return EmployeeWebUserTypeAuthorizationCollection
     * @throws Exception
     */
    public function index(IndexEmployeeWebUserTypeAuthorizationRequest $request): EmployeeWebUserTypeAuthorizationCollection
    {
        $employeeWebUserTypeAuthorizations = $this->employeeWebUserTypeAuthorizationService->index($request);

        return new EmployeeWebUserTypeAuthorizationCollection($employeeWebUserTypeAuthorizations, 'EMPLOYEE_WEB_USER_TYPE_AUTHORIZATION.INDEX.SUCCESS');
    }

    /**
     * @param StoreEmployeeWebUserTypeAuthorizationRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function store(StoreEmployeeWebUserTypeAuthorizationRequest $request): SuccessResource
    {
        $this->employeeWebUserTypeAuthorizationService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param DestroyEmployeeWebUserTypeAuthorizationRequest  $request
     *
     * @return SuccessResource
     * @throws EmployeeAuthorizationNotFoundException
     */
    public function destroy(DestroyEmployeeWebUserTypeAuthorizationRequest $request): SuccessResource
    {
        $this->employeeWebUserTypeAuthorizationService->destroy($request);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }

    /**
     * @param BulkEmployeeWebUserTypeAuthorizationRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function bulk(BulkEmployeeWebUserTypeAuthorizationRequest $request): SuccessResource
    {
        $this->employeeWebUserTypeAuthorizationService->bulk($request);

        return new SuccessResource(__('messages.' . self::class . '.BULK'));
    }
}
