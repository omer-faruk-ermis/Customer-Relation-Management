<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class AuthInformationException extends AbstractException
{
    public function __construct(
        string    $message = 'Mail veya şifre bilgisi hatalı!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
