<?php

namespace App\Exceptions\Module;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class ModuleAlreadyHaveException extends AbstractException
{
    public function __construct(
        string    $message = 'Modül kaydı zaten mevcut!',
        int       $code = Response::HTTP_ALREADY_REPORTED,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
