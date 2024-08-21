<?php

namespace App\Exceptions\Menu;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class MenuAlreadyHaveException extends AbstractException
{
    public function __construct(
        string    $message = 'Menü kaydı zaten mevcut!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
