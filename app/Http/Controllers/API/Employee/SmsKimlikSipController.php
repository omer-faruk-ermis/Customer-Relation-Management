<?php

namespace App\Http\Controllers\API\Employee;

use App\Exceptions\Employee\EmployeeSipNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\IndexEmployeeSipRequest;
use App\Http\Requests\Employee\StoreEmployeeSipRequest;
use App\Http\Resources\Employee\EmployeeSipCollection;
use App\Http\Resources\Employee\EmployeeSipResource;
use App\Http\Resources\SuccessResource;
use App\Services\Employee\EmployeeSipService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class SmsKimlikSipController
 *
 * @package App\Http\Controllers\API\Employee
 */
class SmsKimlikSipController extends Controller
{
    /** @var EmployeeSipService $employeeSipService */
    private EmployeeSipService $employeeSipService;

    /**
     * SmsKimlikSipController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->employeeSipService = new EmployeeSipService($request);
    }

    /**
     * @param IndexEmployeeSipRequest  $request
     *
     * @return EmployeeSipCollection
     */
    public function index(IndexEmployeeSipRequest $request): EmployeeSipCollection
    {
        $employeeSips = $this->employeeSipService->index($request);

        return new EmployeeSipCollection($employeeSips, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreEmployeeSipRequest  $request
     *
     * @return EmployeeSipResource
     * @throws Exception
     */
    public function store(StoreEmployeeSipRequest $request): EmployeeSipResource
    {
        $employeeSip = $this->employeeSipService->store($request);

        return new EmployeeSipResource($employeeSip, __('messages.' . self::class . '.CREATE'), Response::HTTP_CREATED);
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws EmployeeSipNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->employeeSipService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
