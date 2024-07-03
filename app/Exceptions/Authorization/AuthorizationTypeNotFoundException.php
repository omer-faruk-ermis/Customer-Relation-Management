<?php

namespace App\Exceptions\Authorization;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class AuthorizationTypeNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Yetki tipi bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
