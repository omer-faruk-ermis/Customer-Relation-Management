<?php

namespace App\Exceptions\Sms;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class OtpMessageNotSendException extends AbstractException
{
    public function __construct(
        string    $message = 'OTP message gönderilemedi!',
        int       $code = Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
