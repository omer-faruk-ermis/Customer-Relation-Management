<?php

namespace App\Exceptions\Code;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class SecurityCodeMaxAttemptException extends AbstractException
{
    public function __construct(
        string    $message = 'Kodu 3 kez hatalı girdiğiniz için geçersiz kılındı! Lütfen kodu tekrar gönderin.',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
