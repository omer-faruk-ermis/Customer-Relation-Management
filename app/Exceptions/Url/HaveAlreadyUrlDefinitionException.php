<?php

namespace App\Exceptions\Url;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class HaveAlreadyUrlDefinitionException extends AbstractException
{
    public function __construct(
        string    $message = 'Girilen alt menü kaydı zaten mevcut!',
        int       $code = Response::HTTP_CONFLICT,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
