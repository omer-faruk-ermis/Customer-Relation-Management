<?php

namespace App\Exceptions\Code;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class SecurityCodeIncorrectException extends AbstractException
{
    public function __construct(
        string    $message = '',
        int       $code = Response::HTTP_BAD_REQUEST,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
