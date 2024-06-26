<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class AgainPasswordException extends AbstractException
{
    public function __construct(
        string    $message = 'Tekrar girdiğiniz şifre bilgisi hatalıdır.',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
