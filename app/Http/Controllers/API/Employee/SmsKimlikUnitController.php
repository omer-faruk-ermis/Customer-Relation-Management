<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\IndexEmployeeUnitRequest;
use App\Http\Resources\Employee\EmployeeUnitCollection;
use App\Services\Employee\EmployeeUnitService;

/**
 * Class SmsKimlikUnitController
 *
 * @package App\Http\Controllers\API\Employee
 */
class SmsKimlikUnitController extends Controller
{
    /** @var EmployeeUnitService $employeeSipService */
    private EmployeeUnitService $employeeUnitService;

    /**
     * SmsKimlikUnitController constructor
     */
    public function __construct()
    {
        $this->employeeUnitService = new EmployeeUnitService();
    }

    /**
     * @param IndexEmployeeUnitRequest $request
     * @return EmployeeUnitCollection
     */
    public function index(IndexEmployeeUnitRequest $request): EmployeeUnitCollection
    {
        $employeeUnits = $this->employeeUnitService->index($request);

        return new EmployeeUnitCollection($employeeUnits, __('messages.' . self::class . '.INDEX'));
    }
}
