<?php

namespace App\Http\Middleware;

use App\Models\Log\KibanaLog;
use Closure;
use Illuminate\Http\Request;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        (new KibanaLog())->send();

        return $next($request);
    }
}
