<?php

namespace App\Http\Middleware;

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
        $token = $request->input('netgsmsessionid');
        TokenValidate::handle($token);

        if (!Cache::get("login_$token")) {
            throw new NotLoginException();
        }
        self::AuthCheck($token);

        return $next($request);
    }

    /**
     * @param string  $token
     *
     * @return void
     * @throws NotLoginException
     */
    private function AuthCheck(string $token): void
    {
        Auth::login(Cache::get("sms_kimlik_$token"));
        if (empty(Auth::user())) {
            CacheOperation::refreshEmployeeSession($token);
            Auth::login(Cache::get("sms_kimlik_$token"));
        }
    }
}
