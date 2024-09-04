<?php

namespace App\Exceptions\Voice;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class VoiceUserNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
