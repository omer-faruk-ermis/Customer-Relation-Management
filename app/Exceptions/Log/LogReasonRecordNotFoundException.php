<?php

namespace App\Exceptions\Log;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class LogReasonRecordNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Sebep log kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
