<?php

namespace App\Http\Controllers\API\Authorization;

use App\Exceptions\Authorization\EmployeeAuthorizationNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\StoreEmployeeAuthorizationRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Authorization\EmployeeAuthorizationService;

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
     */
    public function __construct()
    {
        $this->employeeAuthorizationService = new EmployeeAuthorizationService();
    }

    /**
     * @param StoreEmployeeAuthorizationRequest  $request
     *
     * @return SuccessResource
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
