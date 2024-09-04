<?php

namespace App\Exceptions\QuestionAnswer;

use App\Exceptions\AbstractException;
use Illuminate\Http\Response;

class QuestionAnswerCategoryNotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;
}
