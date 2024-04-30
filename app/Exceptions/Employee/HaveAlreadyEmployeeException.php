<?php

namespace App\Exceptions\Employee;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class HaveAlreadyEmployeeException extends AbstractException
{
    public function __construct(
        string    $message = 'Girilen mail ile kayıtlı personel kaydı zaten mevcut!',
        int       $code = Response::HTTP_CONFLICT,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
