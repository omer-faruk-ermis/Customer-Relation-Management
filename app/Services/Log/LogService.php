<?php

namespace App\Services\Log;

use App\Constants\WidgetId;
use App\Enums\DefaultConstant;
use App\Exceptions\Log\LogReasonRecordNotFoundException;
use App\Models\Log\SebepLog;
use App\Models\Log\SmsKimlikLog;
use App\Services\AbstractService;
use Illuminate\Http\Request;

/**
 * Class LogService
 *
 * @package App\Service\Log
 */
class LogService extends AbstractService
{
    protected array $privateMethods = [
        'index'             => WidgetId::EMPLOYEE_LOG,
        'update_reason_log' => WidgetId::EMPLOYEE_LOG
    ];

    /**
     * @param Request  $request
     *
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $logs = SmsKimlikLog::with([
                                       'employee',
                                       'reasonLog',
                                       'webUser',
                                       'reasonLog.reason',
                                       'reasonWanted'
                                   ])
                            ->filter($request->all())
                            ->paginate(DefaultConstant::PAGINATE);

        $logs->each(function ($item, $key) use ($request, $logs) {
            if ($request->input('log_subject') && $item?->reasonWanted?->ifade !== $request->input('log_subject')) {
                unset($logs[$key]);
            } else {
                if (!empty($item?->reasonWanted) && ($item?->reasonWanted->alan_adi !== $item->alanadi)) {
                    $item->unsetRelation('reasonWanted');
                }
            }
        });

        return $logs;
    }

    /**
     * @param Request  $request
     *
     * @return SebepLog
     * @throws LogReasonRecordNotFoundException
     */
    public function updateReasonLog(Request $request): SebepLog
    {
        $reasonLog = SebepLog::where('logid', '=', $request->input('log_id'))->first();
        if (empty($reasonLog)) {
            throw new LogReasonRecordNotFoundException();
        }

        $reasonLog->update([
                               'sebep_id' => $request->input('reason_id', $reasonLog->sebep_id),
                               'aciklama' => $request->input('description', $reasonLog->aciklama),
                           ]);

        return $reasonLog;
    }
}
