<?php

namespace App\Http\Controllers\API\Employee;

use App\Exceptions\Employee\EmployeeNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\BasicEmployeeRequest;
use App\Http\Requests\Employee\ChangePasswordEmployeeRequest;
use App\Http\Requests\Employee\IndexEmployeeLogRequest;
use App\Http\Requests\Employee\IndexEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\Employee\EmployeeBasicCollection;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Services\Employee\EmployeeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->employeeService = new EmployeeService($request);
    }

    /**
     * @param IndexEmployeeRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexEmployeeRequest $request): PaginationResource
    {
        $employees = $this->employeeService->index($request);

        return new PaginationResource($employees, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param BasicEmployeeRequest  $request
     *
     * @return EmployeeBasicCollection
     */
    public function basic(BasicEmployeeRequest $request): EmployeeBasicCollection
    {
        $employees = $this->employeeService->basic($request);

        return new EmployeeBasicCollection($employees, __('messages.' . self::class . '.BASIC'));
    }

    /**
     * @param IndexEmployeeLogRequest  $request
     *
     * @return PaginationResource
     * @throws ForbiddenException
     */
    public function log(IndexEmployeeLogRequest $request): PaginationResource
    {
        $logs = $this->employeeService->log($request);

        return new PaginationResource($logs, __('messages.' . self::class . '.LOG'));
    }

    /**
     * @param string  $id
     *
     * @return EmployeeResource
     * @throws EmployeeNotFoundException
     */
    public function show(string $id): EmployeeResource
    {
        $employee = $this->employeeService->show($id);

        return new EmployeeResource($employee, __('messages.' . self::class . '.SHOW'));
    }

    /**
     * @param StoreEmployeeRequest  $request
     *
     * @return EmployeeResource
     * @throws Exception
     */
    public function store(StoreEmployeeRequest $request): EmployeeResource
    {
        $employee = $this->employeeService->store($request);

        return new EmployeeResource($employee, __('messages.' . self::class . '.CREATE'), Response::HTTP_CREATED);
    }

    /**
     * @param UpdateEmployeeRequest  $request
     * @param string                 $id
     *
     * @return EmployeeResource
     * @throws EmployeeNotFoundException
     */
    public function update(UpdateEmployeeRequest $request, string $id): EmployeeResource
    {
        $employee = $this->employeeService->update($request, $id);

        return new EmployeeResource($employee, __('messages.' . self::class . '.UPDATE'));
    }

    /**
     * @param ChangePasswordEmployeeRequest  $request
     * @param string                         $id
     *
     * @return SuccessResource
     * @throws EmployeeNotFoundException
     */
    public function changePassword(ChangePasswordEmployeeRequest $request, string $id): SuccessResource
    {
        $this->employeeService->changePassword($request, $id);

        return new SuccessResource(__('messages.' . self::class . '.PASSWORD_UPDATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws EmployeeNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->employeeService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
