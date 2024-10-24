<?php

namespace App\Http\Controllers\API\Blocked;

use App\Exceptions\Blocked\BlockedPhoneAlreadyHaveException;
use App\Exceptions\Blocked\BlockedPhoneNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blocked\IndexBlockedPhoneRequest;
use App\Http\Requests\Blocked\StoreBlockedPhoneRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Services\Blocked\BlockedPhoneService;
use Illuminate\Http\Request;

/**
 * Class EngellenenTelNoController
 *
 * @package App\Http\Controllers\API\Blocked
 */
class EngellenenTelNoController extends Controller
{
    /** @var BlockedPhoneService $blockedPhoneService */
    private BlockedPhoneService $blockedPhoneService;

    /**
     * EngellenenTelNoController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->blockedPhoneService = new BlockedPhoneService($request);
    }

    /**
     * @param IndexBlockedPhoneRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexBlockedPhoneRequest $request): PaginationResource
    {
        $blockedPhone = $this->blockedPhoneService->index($request);

        return new PaginationResource($blockedPhone, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreBlockedPhoneRequest  $request
     *
     * @return SuccessResource
     * @throws BlockedPhoneAlreadyHaveException
     */
    public function store(StoreBlockedPhoneRequest $request): SuccessResource
    {
        $this->blockedPhoneService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws BlockedPhoneNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->blockedPhoneService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
