<?php

namespace App\Services\Log;

use App\Enums\DefaultConstant;
use App\Exceptions\Log\LogRecordNotFoundException;
use App\Models\Log\SebepLog;
use App\Models\Log\SmsKimlikLog;
use Illuminate\Http\Request;

/**
 * Class LogService
 *
 * @package App\Service\Log
 */
class LogService
{
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
            'reasonLog.reason',
            'reasonWanted'
        ])
            ->filter($request->all())
            ->paginate(DefaultConstant::PAGINATE);

        $logs->each(function ($item) {
            if ($item?->reasonWanted->alan_adi !== $item->alanadi) {
                $item->unsetRelation('reasonWanted');
            }
        });

        return $logs;
    }

    /**
     * @param Request  $request
     *
     * @return SebepLog
     * @throws LogRecordNotFoundException
     */
    public function updateSebepLog(Request $request): SebepLog
    {
        $sebepLog = SebepLog::where('logid', '=', $request->logid)->first();

        if (empty($sebepLog)) {
            throw new LogRecordNotFoundException();
        }

        $sebepLog->update([
            'sebep_id'  => $request->input('sebep_id', $sebepLog->sebep_id),
            'kayit_id'  => $request->input('kayit_id', $sebepLog->kayit_id),
            'kayit_ip'  => $request->ip(),
            'kayit_tar' => $sebepLog->kayit_tar,
            'aciklama'  => $request->input('aciklama', $sebepLog->aciklama),
        ]);

        return $sebepLog;
    }
}
