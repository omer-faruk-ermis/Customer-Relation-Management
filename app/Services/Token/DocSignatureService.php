<?php

namespace App\Services\Token;

use App\Enums\DefaultConstant;
use App\Services\AbstractService;
use App\Utils\DateUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class DocSignatureService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return object
     */
    public static function getSignatureToken(Request $request): object
    {
        $value = array(
            'id'       => Auth::id(),
            'ad_soyad' => Auth::user()->ad_soyad,
            'time'     => DateUtil::now()
        );
        $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        $token = substr(hash('md5', $value), 0, 32);

        Redis::connection('prod')->set("pdfimzalasrv_bearertoken_:$token", $value);
        Redis::connection('prod')->command('EXPIRE', ["pdfimzalasrv_bearertoken_:$token", DefaultConstant::CACHE_ONE_DAY]);

        return (object) ['token' => $token];
    }
}
