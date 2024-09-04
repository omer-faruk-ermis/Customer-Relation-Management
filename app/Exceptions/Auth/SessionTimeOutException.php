<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class SessionTimeOutException extends AbstractException
{
    protected $code = Response::HTTP_REQUEST_TIMEOUT;
}
