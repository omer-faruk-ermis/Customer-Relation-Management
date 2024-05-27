<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Throwable;

class ForbiddenException extends AbstractException
{
    public function __construct(
        string    $message = 'Forbidden!',
        int       $code = Response::HTTP_FORBIDDEN,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
