<?php

namespace App\Exceptions\Log;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class LogReasonRecordNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
