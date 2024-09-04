<?php

namespace App\Http\Controllers\API\Log;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Log\IndexLogRequest;
use App\Http\Requests\Reason\UpdateReasonRequest;
use App\Http\Resources\Log\ReasonLogResource;
use App\Http\Resources\PaginationResource;
use App\Services\Log\LogService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class LogController
 *
 * @package App\Http\Controllers\API\Log
 */
class LogController extends Controller
{
    /** @var LogService $logService */
    private LogService $logService;

    /**
     * LogController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->logService = new LogService($request);
    }

    /**
     * @param IndexLogRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexLogRequest $request): PaginationResource
    {
        $logs = $this->logService->index($request);

        return new PaginationResource($logs, __('messages.' . self::class . '.EMPLOYEE.INDEX'));
    }

    /**
     * @param UpdateReasonRequest  $request
     *
     * @return ReasonLogResource
     * @throws Exception
     */
    public function updateReasonLog(UpdateReasonRequest $request): ReasonLogResource
    {
        $reasonLogs = $this->logService->updateReasonLog($request);

        return new ReasonLogResource($reasonLogs, __('messages.' . self::class . '.REASON.UPDATE'));
    }
}
