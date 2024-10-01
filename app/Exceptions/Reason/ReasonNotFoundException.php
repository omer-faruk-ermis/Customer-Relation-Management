<?php

namespace App\Exceptions\Reason;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class ReasonNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
