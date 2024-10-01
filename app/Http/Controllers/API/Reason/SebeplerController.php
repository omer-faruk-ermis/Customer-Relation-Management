<?php

namespace App\Http\Controllers\API\Reason;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Reason\ReasonNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reason\StoreReasonRequest;
use App\Http\Requests\Reason\UpdateReasonRequest;
use App\Http\Requests\Reason\IndexReasonRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\Reason\ReasonCollection;
use App\Http\Resources\Reason\ReasonResource;
use App\Http\Resources\SuccessResource;
use App\Services\Reason\ReasonService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class SebeplerController
 *
 * @package App\Http\Controllers\API\Reason
 */
class SebeplerController extends Controller
{
    /** @var ReasonService $reasonService */
    private ReasonService $reasonService;

    /**
     * SebeplerController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->reasonService = new ReasonService($request);
    }

    /**
     * @param IndexReasonRequest  $request
     *
     * @return PaginationResource|ReasonCollection
     * @throws Exception
     */
    public function index(IndexReasonRequest $request): PaginationResource|ReasonCollection
    {
        $reasons = $this->reasonService->index($request);

        return $request->input('page')
            ? new PaginationResource($reasons, __('messages.' . self::class . '.INDEX'))
            : new ReasonCollection($reasons, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreReasonRequest  $request
     *
     * @return SuccessResource
     */
    public function store(StoreReasonRequest $request): SuccessResource
    {
        $this->reasonService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param UpdateReasonRequest  $request
     * @param string               $id
     *
     * @return ReasonResource
     * @throws ReasonNotFoundException
     */
    public function update(UpdateReasonRequest $request, string $id): ReasonResource
    {
        $reason = $this->reasonService->update($request, $id);

        return new ReasonResource($reason, __('messages.' . self::class . '.UPDATE'));
    }
}
