<?php

namespace App\Exceptions\Meeting;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class MeetingMainNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
