<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\NotLoginException;
use App\Helpers\TokenValidate;
use Closure;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Cache;

class AuthWithTokenMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
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

        return $next($request);
    }
}
