<?php

namespace App\Exceptions\Auth;

use App\Enums\DefaultConstant;
use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class PasswordLengthException extends AbstractException
{
    public function __construct(
        string    $message = "Şifre minimum " . DefaultConstant::MIN_PASSWORD_LENGTH . "karakter uzunluğunda olmalıdır.",
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
