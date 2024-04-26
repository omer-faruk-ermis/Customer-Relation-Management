<?php

namespace App\Http\Controllers\API\Employee;

use App\Exceptions\Employee\EmployeeNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\BasicEmployeeRequest;
use App\Http\Requests\Employee\ChangePasswordEmployeeRequest;
use App\Http\Requests\Employee\IndexEmployeeLogRequest;
use App\Http\Requests\Employee\IndexEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\Employee\EmployeeBasicCollection;
use App\Http\Resources\Employee\EmployeeCollection;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Services\Employee\EmployeeService;
use App\Services\Log\LogService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

/**
 * Class SmsKimlikController
 *
 * @package App\Http\Controllers\API\Employee
 */
class SmsKimlikController extends Controller
{
    /** @var EmployeeService $employeeService */
    private EmployeeService $employeeService;

    /**
     * SmsKimlikController constructor
     */
    public function __construct()
    {
        $this->employeeService = new EmployeeService();
    }

    /**
     * @param IndexEmployeeRequest $request
     * @return EmployeeCollection
     */
    public function index(IndexEmployeeRequest $request): EmployeeCollection
    {
        $employees = $this->employeeService->index($request);

        return new EmployeeCollection($employees, 'EMPLOYEE.INDEX.SUCCESS');
    }

    /**
     * @param BasicEmployeeRequest $request
     * @return EmployeeBasicCollection
     */
    public function basic(BasicEmployeeRequest $request): EmployeeBasicCollection
    {
        $employees = $this->employeeService->basic($request);

        return new EmployeeBasicCollection($employees, 'EMPLOYEE.BASIC.SUCCESS');
    }

    /**
     * @param IndexEmployeeLogRequest $request
     *
     * @return PaginationResource
     */
    public function log(IndexEmployeeLogRequest $request): PaginationResource
    {
        $logs = $this->employeeService->log($request);

        return new PaginationResource($logs, 'EMPLOYEE.LOG.SUCCESS');
    }

    /**
     * @param int $id
     * @return EmployeeResource
     * @throws EmployeeNotFoundException
     */
    public function show(int $id): EmployeeResource
    {
        $employee = $this->employeeService->show($id);

        return new EmployeeResource($employee, 'EMPLOYEE.SHOW.SUCCESS');
    }

    /**
     * @param StoreEmployeeRequest $request
     * @return EmployeeResource
     * @throws Exception
     */
    public function store(StoreEmployeeRequest $request): EmployeeResource
    {
        $employee = $this->employeeService->store($request);

        return new EmployeeResource($employee, 'EMPLOYEE.STORE.SUCCESS', Response::HTTP_CREATED);
    }

    /**
     * @param UpdateEmployeeRequest $request
     * @param int $id
     * @return EmployeeResource
     * @throws EmployeeNotFoundException
     */
    public function update(UpdateEmployeeRequest $request, int $id): EmployeeResource
    {
        $employee = $this->employeeService->update($request, $id);

        return new EmployeeResource($employee, 'EMPLOYEE.UPDATE.SUCCESS');
    }

    /**
     * @param ChangePasswordEmployeeRequest $request
     * @param int $id
     * @return SuccessResource
     * @throws EmployeeNotFoundException
     */
    public function changePassword(ChangePasswordEmployeeRequest $request, int $id): SuccessResource
    {
        $this->employeeService->changePassword($request, $id);

        return new SuccessResource('EMPLOYEE.PASSWORD.UPDATE.SUCCESS');
    }

    /**
     * @param int $id
     * @return SuccessResource
     * @throws EmployeeNotFoundException
     */
    public function destroy(int $id): SuccessResource
    {
        $this->employeeService->destroy($id);

        return new SuccessResource('EMPLOYEE.DESTROY.SUCCESS');
    }
}
