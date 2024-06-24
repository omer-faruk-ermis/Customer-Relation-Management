<?php

namespace App\Http\Controllers\API\Enum;

use App\Exceptions\InvalidEnumException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Enum\IndexEnumRequest;
use App\Http\Resources\SuccessDataResource;
use App\Services\EnumService;

/**
 * Class EnumController
 *
 * @package App\Http\Controllers\API\Enum
 */
class EnumController extends Controller
{
    /** @var EnumService $enumService */
    private EnumService $enumService;

    /**
     * EnumController constructor
     */
    public function __construct()
    {
        $this->enumService = new EnumService();
    }

    /**
     * @param IndexEnumRequest  $request
     *
     * @return SuccessDataResource
     * @throws InvalidEnumException
     */
    public function index(IndexEnumRequest $request): SuccessDataResource
    {
        $enums = $this->enumService->index($request);

        return new SuccessDataResource($enums, 'ENUM.SUCCESS');
    }
}
