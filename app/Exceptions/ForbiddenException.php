<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ForbiddenException extends AbstractException
{
    protected $code = Response::HTTP_FORBIDDEN;
}
