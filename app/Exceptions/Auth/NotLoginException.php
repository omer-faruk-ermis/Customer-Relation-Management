<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class NotLoginException extends AbstractException
{
    protected $code = Response::HTTP_UNAUTHORIZED;
}
