<?php

namespace App\Exceptions\WebPortal;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class WebPortalAuthorizationPermissionNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Web Portal izni bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
