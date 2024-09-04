<?php

namespace App\Exceptions\WebPortal;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class WebPortalAuthorizationPermissionNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
