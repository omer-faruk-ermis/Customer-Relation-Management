<?php

namespace App\Services\Reason;

use App\Enums\Code;
use App\Enums\DefaultConstant;
use App\Exceptions\Sms\OtpMessageNotSendException;
use App\Helpers\CacheClear;
use App\Helpers\SmsVerificationValidate;
use App\Helpers\TokenValidate;
use App\Http\Proxies\SmsProxy;
use App\Http\Requests\Sms\SmsVerificationRequest;
use App\Models\Sebep\SebepIstenecekler;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Class ReasonWantedService
 *
 * @package App\Service\Reason
 */
class ReasonWantedService
{
    /**
     * @param Request $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return SebepIstenecekler::limit(DefaultConstant::SEARCH_LIST_LIMIT)->get();
    }
}
