<?php

namespace App\Exceptions\Sms;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class OtpMessageNotSendException extends AbstractException
{
    protected $code = Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS;
}
