<?php

namespace App\Exceptions\Url;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class UrlDefinitionNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Alt menü kaydı bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
