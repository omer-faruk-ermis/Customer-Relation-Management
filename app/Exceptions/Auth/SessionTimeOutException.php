<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class SessionTimeOutException extends AbstractException
{
    public function __construct(
        string    $message = 'Oturum süresi doldu!',
        int       $code = Response::HTTP_REQUEST_TIMEOUT,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
