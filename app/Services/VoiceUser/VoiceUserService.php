<?php

namespace App\Services\VoiceUser;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\Call\CallNotFoundException;
use App\Exceptions\WebUser\WebUserNotFoundException;
use App\Models\Call\Cagri;
use App\Models\Voice\SesUser;
use App\Models\WebUser\WebUser;
use App\Services\AbstractService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class VoiceUserService
 *
 * @package App\Service\VoiceUser
 */
class VoiceUserService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::DEFINE_REASON
        ],
    ];

    /**
     * @param Request  $request
     *
     * @return void
     * @throws CallNotFoundException
     * @throws WebUserNotFoundException
     */
    public function store(Request $request): void
    {
        $call = Cagri::find($request->input('call_id'));
        if (empty($call)) {
            throw new CallNotFoundException();
        }

        $webUser = WebUser::find($request->input('user_id'));
        if (empty($webUser)) {
            throw new WebUserNotFoundException();
        }

        SesUser::create([
                            'cagri_id'      => $request->input('call_id'),
                            'userid'        => $request->input('user_id'),
                            'eslestiren_id' => Auth::id(),
                            'eslestiren_ip' => $request->ip(),
                            'eslesme_tar'   => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
                            'sildurum'      => Status::PASSIVE,
                            'tip'           => $request->input('type') ?? NumericalConstant::ZERO,
                            'kul_tur'       => $request->input('user_type'),
                        ]);
    }

    /**
     * @param Request  $request
     *
     * @return object
     */
    public function path(Request $request): object
    {
        $voiceRecord = $request->input('voice_record');

        $callStartDateFormatted = Carbon::createFromFormat(DefaultConstant::DEFAULT_DATE_FORMAT,
                                                           substr($request->input('call_start_date'), 0, 10))
                                        ->format(DefaultConstant::DATE_YMD_LINK_FORMAT);
        if (substr($voiceRecord, 0, 10) === $callStartDateFormatted) {
            return (object)['path' => $voiceRecord];
        } else {
            return (object)['path' => $callStartDateFormatted . '/' . $voiceRecord];
        }
    }

    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function lastPair(Request $request): Collection
    {
        return WebUser::select('ceptel')
                      ->whereIn('id',
                                SesUser::select('userid')
                                       ->whereIn('cagri_id',
                                                 Cagri::select('id')
                                                      ->where('cid', $request->input('call_phone')))
                      )
                      ->where('ceptel', '<>', (string)NumericalConstant::ZERO)
                      ->distinct()
                      ->get();
    }
}
