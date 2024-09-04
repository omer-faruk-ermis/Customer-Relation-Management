<?php

namespace App\Exceptions\Staff;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class StaffGroupMatchNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
