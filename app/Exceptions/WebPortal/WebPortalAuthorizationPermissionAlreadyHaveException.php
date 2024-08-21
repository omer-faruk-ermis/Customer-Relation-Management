<?php

namespace App\Exceptions\WebPortal;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class WebPortalAuthorizationPermissionAlreadyHaveException extends AbstractException
{
    public function __construct(
        string    $message = 'Web Portal izin kaydı zaten mevcut!',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
