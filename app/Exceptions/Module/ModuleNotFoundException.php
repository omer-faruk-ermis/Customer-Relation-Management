<?php

namespace App\Exceptions\Module;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class ModuleNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Modül kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
