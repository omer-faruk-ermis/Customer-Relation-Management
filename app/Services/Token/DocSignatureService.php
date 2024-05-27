<?php

namespace App\Services\Token;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DocSignatureService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::NEW_ANNOUNCEMENTS,
        ]
    ];

    /**
     * @param Request  $request
     *
     * @return array
     */
    public static function getSignatureToken(Request $request): array
    {
        $value = array(
            'id'       => Auth::id(),
            'ad_soyad' => Auth::user()->ad_soyad,
            'time'     => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT)
        );
        $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        $token = substr(hash('md5', $value), 0, 32);

        // Cache::store('memcached')->put("pdfimzalasrv_bearertoken_:$token", $value, DefaultConstant::CACHE_ONE_DAY);

        return ['token' => $token];
    }
}
