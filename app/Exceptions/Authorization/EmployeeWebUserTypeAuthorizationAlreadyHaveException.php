<?php

namespace App\Exceptions\Authorization;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class EmployeeWebUserTypeAuthorizationAlreadyHaveException extends AbstractException
{
    public function __construct(
        string    $message = 'Personelin kullanıcı tipi ile ilişkili yetki kaydı zaten mevcut!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
