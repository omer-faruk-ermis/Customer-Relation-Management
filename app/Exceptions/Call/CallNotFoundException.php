<?php

namespace App\Exceptions\Call;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class CallNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
