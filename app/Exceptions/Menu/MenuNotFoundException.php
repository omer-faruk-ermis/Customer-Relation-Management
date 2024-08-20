<?php

namespace App\Exceptions\Menu;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class MenuNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Menü kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
