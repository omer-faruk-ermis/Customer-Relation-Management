<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class OldPasswordException extends AbstractException
{
    public function __construct(
        string    $message = 'Eski şifreniz ile girilen eski şifre bilgisi uyuşmamaktadır.',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
