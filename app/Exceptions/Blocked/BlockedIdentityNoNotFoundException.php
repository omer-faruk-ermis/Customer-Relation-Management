<?php

namespace App\Exceptions\Blocked;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class BlockedIdentityNoNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}