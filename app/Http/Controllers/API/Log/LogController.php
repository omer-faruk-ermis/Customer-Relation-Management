<?php

namespace App\Http\Controllers\API\Log;

use App\Enums\DefaultConstant;
use App\Exceptions\Log\LogRecordNotFoundException;
use App\Helpers\QueryBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Log\IndexLogRequest;
use App\Http\Requests\Reason\UpdateReasonRequest;
use App\Models\Log\SebepLog;
use App\Models\Log\SmsKimlikLog;
use App\Models\Sebep\SebepAlanAciklama;
use App\Models\Sebep\SebepIstenecekler;
use App\Models\SmsKimlik\SmsKimlik;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    /**
     * @param IndexLogRequest $request
     * @return mixed
     */
    public function index(IndexLogRequest $request): mixed
    {
        $smsKimlik = SmsKimlik::getModel();
        $smsKimlikLog = SmsKimlikLog::getModel();
        $sebepIstenecekler = SebepIstenecekler::getModel();
        $sebepLog = SebepLog::getModel();
        $sebepAlanAciklama = SebepAlanAciklama::getModel();

        return SmsKimlikLog::with('sebepLog')
            ->filter($request->all())
            ->select(
                $smsKimlik->qualifyAllColumns(),
                $smsKimlikLog->qualifyAllColumns(),
                DB::raw($sebepAlanAciklama->getQualifiedKeyName() . ' AS sebep_alan_aciklama_id'),
                DB::raw($sebepAlanAciklama->qualifyColumn('aciklama') . ' AS sebep_alan_aciklama'),
                $sebepAlanAciklama->qualifyColumn('sql_cumle'),
                $sebepAlanAciklama->qualifyColumn('deger'),
                $sebepAlanAciklama->qualifyColumn('tur'),
                DB::raw($sebepIstenecekler->getQualifiedKeyName() . ' AS sebep_istenecekler_id'),
                $sebepIstenecekler->qualifyColumn('ifade'),
                DB::raw($sebepLog->getQualifiedKeyName() . ' AS sebeplog_id'),
                DB::raw($sebepLog->qualifyColumn('aciklama') . ' AS sebeplog_aciklama'),
                $sebepLog->qualifyColumn('sebep_id'),
                $sebepLog->qualifyColumn('logid'),
                $sebepLog->qualifyColumn('userid'),
                $sebepLog->qualifyColumn('kayit_id'),
                $sebepLog->qualifyColumn('kayit_ip'),
                $sebepLog->qualifyColumn('kayit_tar'),
            )
            ->join($smsKimlik->getTable(),
                $smsKimlikLog->qualifyColumn('smskimlik'),
                '=',
                $smsKimlik->getQualifiedKeyName())
            ->join($sebepLog->getTable(),
                $sebepLog->qualifyColumn('logid'),
                '=',
                $smsKimlikLog->getQualifiedKeyName())
            ->join($sebepAlanAciklama->getTable(), function ($join) use ($smsKimlikLog, $sebepAlanAciklama) {
                $join->on($smsKimlikLog->qualifyColumn('tabloadi'), '=', QueryBuilder::collate($sebepAlanAciklama->qualifyColumn('tabloadi')))
                    ->where($smsKimlikLog->qualifyColumn('alanadi'), '=', QueryBuilder::collate($sebepAlanAciklama->qualifyColumn('alanadi')));
            })
            ->join($sebepIstenecekler->getTable(), function ($join) use ($smsKimlikLog, $sebepIstenecekler) {
                $join->on($smsKimlikLog->qualifyColumn('tabloadi'), '=', QueryBuilder::collate($sebepIstenecekler->qualifyColumn('tablo_adi')))
                    ->where($smsKimlikLog->qualifyColumn('alanadi'), '=', QueryBuilder::collate($sebepIstenecekler->qualifyColumn('alan_adi')));
            })
            ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param UpdateReasonRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function updateSebepLog(UpdateReasonRequest $request): JsonResponse
    {
        $sebepLog = SebepLog::where('logid', '=', $request->logid)->first();

        if (empty($sebepLog)) {
            return throw new LogRecordNotFoundException();
        }

        $sebepLog->update([
            'sebep_id'  => $request->sebep_id,
            'kayit_id'  => $request->input('kayit_id', $sebepLog->kayit_id),
            'kayit_ip'  => $request->ip(),
            'kayit_tar' => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
            'aciklama'  => $request->input('aciklama', $sebepLog->aciklama),
        ]);

        return response()->json($sebepLog, Response::HTTP_OK);
    }
}
