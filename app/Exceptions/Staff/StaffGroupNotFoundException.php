<?php

namespace App\Exceptions\Staff;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class StaffGroupNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
