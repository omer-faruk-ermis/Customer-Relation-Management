<?php

namespace App\Exceptions\DetailMenu;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class DetailMenuUserNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
