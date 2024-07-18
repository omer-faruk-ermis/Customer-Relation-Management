<?php

namespace App\Exceptions\Voice;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class VoiceUserNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Ses ile eşleştirilmiş bir kullanıcı kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
