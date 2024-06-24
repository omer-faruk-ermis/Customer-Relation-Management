<?php

namespace App\Exceptions\Call;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class CallNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Arama kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
