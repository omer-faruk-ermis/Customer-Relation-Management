<?php

namespace App\Http\Controllers\API\Blocked;

use App\Exceptions\Blocked\BlockedIdentityNoAlreadyHaveException;
use App\Exceptions\Blocked\BlockedIdentityNoNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blocked\IndexBlockedIdentityNoRequest;
use App\Http\Requests\Blocked\StoreBlockedIdentityNoRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Services\Blocked\BlockedIdentityNoService;
use Illuminate\Http\Request;

/**
 * Class EngellenenKimlikNoController
 *
 * @package App\Http\Controllers\API\Blocked
 */
class EngellenenKimlikNoController extends Controller
{
    /** @var BlockedIdentityNoService $blockedIdentityNoService */
    private BlockedIdentityNoService $blockedIdentityNoService;

    /**
     * EngellenenKimlikNoController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->blockedIdentityNoService = new BlockedIdentityNoService($request);
    }

    /**
     * @param IndexBlockedIdentityNoRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexBlockedIdentityNoRequest $request): PaginationResource
    {
        $blockedIdentityNo = $this->blockedIdentityNoService->index($request);

        return new PaginationResource($blockedIdentityNo, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreBlockedIdentityNoRequest  $request
     *
     * @return SuccessResource
     * @throws BlockedIdentityNoAlreadyHaveException
     */
    public function store(StoreBlockedIdentityNoRequest $request): SuccessResource
    {
        $this->blockedIdentityNoService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws BlockedIdentityNoNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->blockedIdentityNoService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
