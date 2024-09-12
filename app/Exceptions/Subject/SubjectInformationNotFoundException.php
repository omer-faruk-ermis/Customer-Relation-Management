<?php

namespace App\Exceptions\Subject;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class SubjectInformationNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
