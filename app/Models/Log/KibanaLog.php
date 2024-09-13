<?php

namespace App\Models\Log;

use App\Utils\GitUtil;
use App\Utils\LogUtil;
use App\Utils\RouteUtil;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class KibanaLog
{
    public mixed $hostname;
    public mixed $port;
    public mixed $ip;
    public mixed $program;

    public function __construct()
    {
        $this->hostname = Config::get('kibana.hostname', false);
        $this->port = Config::get('kibana.port', 514);
        $this->ip = Config::get('kibana.ip', '10.10.10.121');
        $this->program = Config::get('kibana.program', 'yonetimagentapi');
    }

    /**
     * @param object|null  $e
     * @param int          $level
     *
     * @return void
     */
    public function send(object $e = null, int $level = LOG_NOTICE): void
    {
        $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

        $uniqid = uniqid();
        $timestamp = date('c');
        $messages = str_split(self::getMessage($e), 6000);
        $part = 'log-first';
        $partCount = 0;

        foreach ($messages as $key => $value) {
            $syslog_message = json_encode(
                [
                    '@timestamp'         => $timestamp,
                    'source'             => gethostname(),
                    'message'            => $value,
                    'file'               => $e?->getFile(),
                    'line'               => $e?->getLine(),
                    'status_code'        => self::getStatusCode($e),
                    'level'              => LogUtil::level2String($level),
                    'thread_id'          => $uniqid,
                    'thread_name'        => 'logger',
                    'program'            => $this->program,
                    'smskimlik_id'       => Auth::id(),
                    'smskimlik_fullname' => Auth::user()?->ad_soyad,
                    'authorization_ids'  => Auth::user()?->yetki_string,
                    'ip'                 => $this->ip,
                    'port'               => $this->port,
                    'request_path'       => Arr::get(Request()->server->all(),'PATH_INFO'),
                    'request_uri'        => Arr::get(Request()->server->all(),'REQUEST_URI'),
                    'request_method'     => Request()->method(),
                    'request_ip'         => Request()->ip(),
                    'request_port'       => Request()->getPort(),
                    'bearer_token'       => Auth::user()?->netgsmsessionid,
                    'page-pathname'      => Arr::get(Arr::get(Request()->header(), 'page-pathname', []), 0),
                    'current_route'      => RouteUtil::currentRoute(),
                    'current_controller' => RouteUtil::currentController(),
                    'app_url'            => strval(config('app.url')),
                    'app_env'            => strval(config('app.env')),
                    'app_branch'         => GitUtil::getCurrentBranch(),
                    'retention'          => 'yearly',
                    'part'               => $part,
                    'trace'              => LogUtil::getTraces($level == LOG_ERR ? $e : null, 10),
                ]
            );

            socket_sendto($sock, $syslog_message, strlen($syslog_message), 0, $this->ip, $this->port);
            $part = 'log-' . $partCount;
            $partCount++;
        }

        socket_close($sock);
    }

    /**
     * @param object|null  $e
     *
     * @return string|null
     */
    private function getMessage(object $e = null): string|null
    {
        if (!empty($e) && method_exists($e, 'getMessage')) {
            return $e?->getMessage();
        } elseif (app()->bound('currentResourceMessage')) {
            return app('currentResourceMessage');
        } else {
            return 'Request';
        }
    }

    /**
     * @param object|null  $e
     *
     * @return mixed
     */
    private function getStatusCode(object $e = null): mixed
    {
        if (!empty($e) && method_exists($e, 'getStatusCode')) {
            return $e->getStatusCode();
        } elseif (!empty($e) && method_exists($e, 'getCode')) {
            return $e->getCode();
        } elseif (app()->bound('currentResourceStatusCode')) {
            return app('currentResourceStatusCode');
        }

        return null;
    }
}
