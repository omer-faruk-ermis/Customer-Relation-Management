<?php

namespace App\Exceptions\DetailMenu;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class DetailMenuUserNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Personel yetki kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
