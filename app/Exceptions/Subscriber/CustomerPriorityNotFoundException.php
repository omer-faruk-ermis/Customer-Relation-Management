<?php

namespace App\Exceptions\Subscriber;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class CustomerPriorityNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
