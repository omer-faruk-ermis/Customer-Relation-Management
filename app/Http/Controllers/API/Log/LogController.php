<?php

namespace App\Http\Controllers\API\Log;

use App\Http\Controllers\Controller;
use App\Http\Requests\Log\IndexLogRequest;
use App\Http\Requests\Reason\UpdateReasonRequest;
use App\Http\Resources\Log\ReasonLogResource;
use App\Http\Resources\PaginationResource;
use App\Services\Log\LogService;
use Exception;

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
     */
    public function __construct()
    {
        $this->logService = new LogService();
    }

    /**
     * @param IndexLogRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexLogRequest $request): PaginationResource
    {
        $logs = $this->logService->index($request);

        return new PaginationResource($logs, 'LOG.INDEX.SUCCESS');
    }

    /**
     * @param UpdateReasonRequest $request
     * @return ReasonLogResource
     * @throws Exception
     */
    public function updateSebepLog(UpdateReasonRequest $request): ReasonLogResource
    {
        $reasonLogs = $this->logService->updateSebepLog($request);

        return new ReasonLogResource($reasonLogs, 'LOG.REASON_LOG.UPDATE.SUCCESS');
    }
}
