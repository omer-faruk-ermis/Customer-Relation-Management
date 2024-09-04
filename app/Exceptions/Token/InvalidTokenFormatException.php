<?php

namespace App\Exceptions\Token;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class InvalidTokenFormatException extends AbstractException
{
    protected $code = Response::HTTP_GONE;
}
