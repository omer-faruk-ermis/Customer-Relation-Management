<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class InvalidPasswordFormatException extends AbstractException
{
    public function __construct(
        string    $message = 'Geçersiz Şifre Formatı!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
