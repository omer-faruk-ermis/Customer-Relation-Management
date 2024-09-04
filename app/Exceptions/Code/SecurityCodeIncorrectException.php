<?php

namespace App\Exceptions\Code;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class SecurityCodeIncorrectException extends AbstractException
{
    protected $code = Response::HTTP_BAD_REQUEST;
}
