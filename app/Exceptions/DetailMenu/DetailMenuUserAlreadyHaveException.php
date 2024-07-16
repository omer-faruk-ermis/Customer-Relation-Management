<?php

namespace App\Exceptions\DetailMenu;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class DetailMenuUserAlreadyHaveException extends AbstractException
{
    public function __construct(
        string    $message = 'Personel yetki kaydı zaten mevcut!',
        int       $code = Response::HTTP_ALREADY_REPORTED,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
