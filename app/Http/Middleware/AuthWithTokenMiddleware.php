<?php

namespace App\Http\Middleware;

use App\Enums\Url\ExcludeRoute;
use App\Exceptions\Auth\NotLoginException;
use App\Helpers\CacheOperation;
use App\Helpers\TokenValidate;
use App\Models\SmsKimlik\SmsKimlik;
use Closure;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use TypeError;

class AuthWithTokenMiddleware
{
    /**
     * @param Request  $request
     * @param Closure  $next
     *
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $excludedRoutes = [
            ExcludeRoute::SECURITY_CODE,
            ExcludeRoute::SMS_CODE,
            ExcludeRoute::LOGIN,
            ExcludeRoute::FORGOT_PASSWORD,
            ExcludeRoute::NEW_PASSWORD,
            ExcludeRoute::LOGIN,
            ExcludeRoute::SMS_VERIFICATION,
            ExcludeRoute::LOGIN_VERIFICATION,
            ExcludeRoute::TELESCOPE,
            ExcludeRoute::LOG_VIEWER,
            ExcludeRoute::WELCOME,
            ExcludeRoute::BASE,
            ExcludeRoute::LARAVEL_LOGS
        ];

        $excludedPrefixes = [
            ExcludeRoute::TELESCOPE_PREFIX,
            ExcludeRoute::DEBUGBAR_PREFIX,
            ExcludeRoute::LOG_VIEWER_PREFIX,
            ExcludeRoute::PUBLIC_PREFIX,
        ];

        if (in_array($request->path(), $excludedRoutes)) {
            return $next($request);
        }

        foreach ($excludedPrefixes as $prefix) {
            if (str_starts_with($request->path(), $prefix)) {
                return $next($request);
            }
        }

        $token = $request->bearerToken();
        self::authCheck($token);
        TokenValidate::handle($token);

        return $next($request);
    }

    /**
     * @param string  $token
     *
     * @return void
     * @throws NotLoginException
     */
    private function authCheck(string $token): void
    {
        CacheOperation::refreshEmployeeSession($token);
        try {
            Auth::login(new SmsKimlik(Cache::get("sms_kimlik_$token")));
        } catch (TypeError $e) {
            Auth::login(Cache::get("sms_kimlik_$token"));
        }
    }
}
