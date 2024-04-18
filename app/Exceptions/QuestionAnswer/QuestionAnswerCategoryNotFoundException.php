<?php

namespace App\Exceptions\QuestionAnswer;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;
use Throwable;

class QuestionAnswerCategoryNotFoundException extends AbstractException
{
    public function __construct(
        string    $message = 'Kategori bulunamadı!',
        int       $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
