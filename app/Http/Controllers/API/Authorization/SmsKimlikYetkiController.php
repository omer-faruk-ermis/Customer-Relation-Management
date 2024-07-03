<?php

namespace App\Http\Controllers\API\Authorization;

use App\Exceptions\Authorization\EmployeeAuthorizationNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\StoreEmployeeAuthorizationRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Authorization\EmployeeAuthorizationService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class SmsKimlikYetkiController
 *
 * @package App\Http\Controllers\API\Authorization
 */
class SmsKimlikYetkiController extends Controller
{
    /** @var EmployeeAuthorizationService $employeeAuthorizationService */
    private EmployeeAuthorizationService $employeeAuthorizationService;

    /**
     * SmsKimlikYetkiController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->employeeAuthorizationService = new EmployeeAuthorizationService($request);
    }

    /**
     * @param StoreEmployeeAuthorizationRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function store(StoreEmployeeAuthorizationRequest $request): SuccessResource
    {
        $this->employeeAuthorizationService->store($request);

        return new SuccessResource('SMS_MANAGEMENT_AUTHORIZATION.CREATE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws EmployeeAuthorizationNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->employeeAuthorizationService->destroy($id);

        return new SuccessResource('SMS_MANAGEMENT_AUTHORIZATION.DESTROY.SUCCESS');
    }
}
