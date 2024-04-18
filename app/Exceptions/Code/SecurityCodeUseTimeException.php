<?php

namespace App\Exceptions\Code;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class SecurityCodeUseTimeException extends AbstractException
{
    public function __construct(
        string    $message = 'Kodu 3 dakikadan uzun süredir girmediğiniz için kodunuz geçersizdir! Lütfen kodu tekrar gönderin.',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
