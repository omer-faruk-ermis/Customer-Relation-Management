<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class AbstractException extends Exception
{
    public function __construct(string $message = "", int $code = Response::HTTP_NOT_ACCEPTABLE, Throwable $previous = null)
    {
        $message = $message ?: ($this->message ?: __('exceptions.' . static::class));

        parent::__construct($message, $this->code != 0 ? $this->code : $code, $previous);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage()
        ], $this->getCode(), [], JSON_UNESCAPED_UNICODE);
    }
}
