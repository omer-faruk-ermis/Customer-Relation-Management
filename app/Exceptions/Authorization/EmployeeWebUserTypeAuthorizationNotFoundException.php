<?php

namespace App\Exceptions\Authorization;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class EmployeeWebUserTypeAuthorizationNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Personelin kullanıcı tipi ile ilişkili yetki kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
