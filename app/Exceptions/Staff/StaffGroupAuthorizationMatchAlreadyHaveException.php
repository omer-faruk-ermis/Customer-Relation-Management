<?php

namespace App\Exceptions\Staff;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class StaffGroupAuthorizationMatchAlreadyHaveException extends AbstractException
{
    public function __construct(
        string    $message = 'Yetki Grubu ile yetki eşleşme kaydı zaten mevcut!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
