<?php

namespace App\Exceptions\WebUser;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class WebUserNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
