<?php

namespace App\Http\Middleware;

use App\Enums\Url\ExcludeRoute;
use App\Exceptions\Auth\NotLoginException;
use App\Helpers\CacheOperation;
use App\Helpers\TokenValidate;
use Closure;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
            ExcludeRoute::SMS_VERIFICATION,
            ExcludeRoute::LOGIN_VERIFICATION
        ];

        if (in_array($request->path(), $excludedRoutes)) {
            return $next($request);
        }

        $token = $request->input('netgsmsessionid');
        TokenValidate::handle($token);

        if (!Cache::get("login_$token")) {
            throw new NotLoginException();
        }
        self::authCheck($token);

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
        Auth::login(Cache::get("sms_kimlik_$token"));
        if (empty(Auth::user())) {
            CacheOperation::refreshEmployeeSession($token);
            Auth::login(Cache::get("sms_kimlik_$token"));
        }
    }
}
