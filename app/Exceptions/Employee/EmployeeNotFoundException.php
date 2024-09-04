<?php

namespace App\Exceptions\Employee;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class EmployeeNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
