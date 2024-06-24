<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Throwable;

class InvalidEnumException extends AbstractException
{
    public function __construct(
        string    $message = 'Invalid Enum Type!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
