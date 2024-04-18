<?php

namespace App\Exceptions\Employee;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class EmployeeSipNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Personel dahili numarası bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
