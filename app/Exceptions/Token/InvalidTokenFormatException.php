<?php

namespace App\Exceptions\Token;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class InvalidTokenFormatException extends AbstractException
{
    public function __construct(
        string    $message = 'Geçersiz Token Formatı!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
