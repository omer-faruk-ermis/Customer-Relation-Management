<?php

namespace App\Exceptions\Menu;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class MenuNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
