<?php

namespace App\Exceptions\Employee;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class HaveAlreadyEmployeeException extends AbstractException
{
    protected $code = Response::HTTP_CONFLICT;
}
