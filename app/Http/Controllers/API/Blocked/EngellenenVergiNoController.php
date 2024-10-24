<?php

namespace App\Http\Controllers\API\Blocked;

use App\Exceptions\Blocked\BlockedTaxIdentificationNoAlreadyHaveException;
use App\Exceptions\Blocked\BlockedTaxIdentificationNoNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blocked\IndexBlockedTaxIdentificationNoRequest;
use App\Http\Requests\Blocked\StoreBlockedTaxIdentificationNoRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Services\Blocked\BlockedTaxIdentificationNoService;
use Illuminate\Http\Request;

/**
 * Class EngellenenVergiNoController
 *
 * @package App\Http\Controllers\API\Blocked
 */
class EngellenenVergiNoController extends Controller
{
    /** @var BlockedTaxIdentificationNoService $blockedTaxIdentificationNoService */
    private BlockedTaxIdentificationNoService $blockedTaxIdentificationNoService;

    /**
     * EngellenenVergiNoController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->blockedTaxIdentificationNoService = new BlockedTaxIdentificationNoService($request);
    }

    /**
     * @param IndexBlockedTaxIdentificationNoRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexBlockedTaxIdentificationNoRequest $request): PaginationResource
    {
        $blockedTaxIdentificationNo = $this->blockedTaxIdentificationNoService->index($request);

        return new PaginationResource($blockedTaxIdentificationNo, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreBlockedTaxIdentificationNoRequest  $request
     *
     * @return SuccessResource
     * @throws BlockedTaxIdentificationNoAlreadyHaveException
     */
    public function store(StoreBlockedTaxIdentificationNoRequest $request): SuccessResource
    {
        $this->blockedTaxIdentificationNoService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws BlockedTaxIdentificationNoNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->blockedTaxIdentificationNoService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
