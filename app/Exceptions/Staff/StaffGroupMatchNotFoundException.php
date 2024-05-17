<?php

namespace App\Exceptions\Staff;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class StaffGroupMatchNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Yetki Grubu ile personel eşleşme kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
