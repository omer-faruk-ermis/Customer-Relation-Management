<?php

namespace App\Exceptions\Sms;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class SmsIdentityNotVerifiedException extends AbstractException
{
    public function __construct(
        string    $message = 'Sms Kimlik Doğrulanamadı!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
