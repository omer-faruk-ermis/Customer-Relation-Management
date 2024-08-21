<?php

namespace App\Exceptions;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class RelationHaveException extends AbstractException
{
    public function __construct(
        string    $message = 'Alt ilişki kaydı mevcut! İşlem yapılamaz.',
        int       $code = Response::HTTP_NOT_ACCEPTABLE,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
