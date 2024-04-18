<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class NotLoginException extends AbstractException
{
    public function __construct(
        string    $message = 'Henüz oturum açılmadı!',
        int       $code = Response::HTTP_UNAUTHORIZED,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
