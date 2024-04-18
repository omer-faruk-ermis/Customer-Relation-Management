<?php

namespace App\Exceptions\Log;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class LogRecordNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Log kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
