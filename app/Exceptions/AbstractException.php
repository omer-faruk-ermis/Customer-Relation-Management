<?php

namespace App\Exceptions;

use App\Enums\NumericalConstant;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class AbstractException extends Exception
{
    public function __construct(string $message = "", int $code = NumericalConstant::ZERO, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage()
        ], $this->getCode(), [], JSON_UNESCAPED_UNICODE);
    }
}
