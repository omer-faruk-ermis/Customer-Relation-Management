<?php

namespace App\Exceptions\Code;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class InvalidSecurityCodeException extends AbstractException
{
    public function __construct(
        string    $message = 'Geçersiz Güvenlik Kodu!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
