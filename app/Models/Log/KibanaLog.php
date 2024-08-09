<?php

namespace App\Models\Log;

use App\Utils\LogUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class KibanaLog
{
    public mixed $hostname;
    public mixed $port;
    public mixed $ip;
    public mixed $program;
    public mixed $smskimlik;

    public function __construct()
    {
        $this->hostname = Config::get('kibana.hostname', false);
        $this->port = Config::get('kibana.port', 514);
        $this->ip = Config::get('kibana.ip', '10.10.10.121');
        $this->program = Config::get('kibana.program', 'yonetimagentapi');
        $this->smskimlik = Auth::id();
    }

    /**
     * @param string|null  $message
     * @param string|null  $file
     * @param int          $line
     * @param int          $level
     *
     * @return void
     */
    public function send(?string $message, ?string $file, int $line = 0, int $level = LOG_NOTICE): void
    {
        $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

        $uniqid = uniqid();
        $timestamp = date('c');
        $messages = str_split($message, 6000);
        $part = 'log-first';
        $partCount = 0;

        foreach ($messages as $key => $value) {
            $syslog_message = json_encode(
                [
                    '@timestamp'  => $timestamp,
                    'source'      => gethostname(),
                    'message'     => $value,
                    'file'        => $file,
                    'line'        => $line,
                    'level'       => LogUtil::level2String($level),
                    'thread_id'   => $uniqid,
                    'thread_name' => 'logger',
                    'program'     => $this->program,
                    'smskimlik'   => strval($this->smskimlik),
                    'retention'   => 'yearly',
                    'part'        => $part,
                ]
            );

            socket_sendto($sock, $syslog_message, strlen($syslog_message), 0, $this->ip, $this->port);
            $part = 'log-' . $partCount;
            $partCount++;
        }

        socket_close($sock);
    }
}
