<?php

namespace App\Exceptions\Staff;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class StaffGroupAuthorizationMatchNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Yetki Grubu ile yetki eşleşme kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
