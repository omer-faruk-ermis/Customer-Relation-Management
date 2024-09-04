<?php

namespace App\Exceptions\Authorization;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class AuthorizationTypeNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
