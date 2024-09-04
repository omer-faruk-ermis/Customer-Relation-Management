<?php

namespace App\Exceptions\Url;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class HaveAlreadyUrlDefinitionException extends AbstractException
{
    protected $code = Response::HTTP_CONFLICT;
}
