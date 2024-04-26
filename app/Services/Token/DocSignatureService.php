<?php

namespace App\Services\Token;

use App\Enums\DefaultConstant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DocSignatureService extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public static function getSignatureToken(Request $request): array
    {
        $netgsmsessionid = $request->input('netgsmsessionid');
        $sms_kimlik = Cache::get("sms_kimlik_$netgsmsessionid");

        $value = array(
            'id'       => $sms_kimlik['id'],
            'ad_soyad' => $sms_kimlik['ad_soyad'],
            'time'     => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT)
        );
        $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        $token = substr(hash('md5', $value), 0, 32);

        // Cache::store('memcached')->put("pdfimzalasrv_bearertoken_:$token", $value, DefaultConstant::CACHE_ONE_DAY);

        return ['token' => $token];
    }
}
