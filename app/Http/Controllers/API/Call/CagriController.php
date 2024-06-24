<?php

namespace App\Http\Controllers\API\Call;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Call\IndexCallRequest;
use App\Http\Resources\PaginationResource;
use App\Services\Call\CallService;
use Illuminate\Http\Request;

/**
 * Class CagriController
 *
 * @package App\Http\Controllers\API\Call
 */
class CagriController extends Controller
{
    /** @var CallService $callService */
    private CallService $callService;

    /**
     * CagriController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->callService = new CallService($request);
    }

    /**
     * @param IndexCallRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexCallRequest $request): PaginationResource
    {
        $calls = $this->callService->index($request);

        return new PaginationResource($calls, 'CALL.INDEX.SUCCESS');
    }
}
