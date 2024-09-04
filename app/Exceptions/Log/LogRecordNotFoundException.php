<?php

namespace App\Exceptions\Log;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class LogRecordNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
