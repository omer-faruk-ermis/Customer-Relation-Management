<?php

namespace App\Exceptions\Url;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class UrlDefinitionNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
