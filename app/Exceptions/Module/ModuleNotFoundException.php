<?php

namespace App\Exceptions\Module;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class ModuleNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
