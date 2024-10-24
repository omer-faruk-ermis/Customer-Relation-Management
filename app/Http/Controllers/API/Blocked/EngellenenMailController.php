<?php

namespace App\Http\Controllers\API\Blocked;

use App\Exceptions\Blocked\BlockedEmailAlreadyHaveException;
use App\Exceptions\Blocked\BlockedEmailNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blocked\IndexBlockedEmailRequest;
use App\Http\Requests\Blocked\StoreBlockedEmailRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Services\Blocked\BlockedEmailService;
use Illuminate\Http\Request;

/**
 * Class EngellenenMailController
 *
 * @package App\Http\Controllers\API\Blocked
 */
class EngellenenMailController extends Controller
{
    /** @var BlockedEmailService $blockedEmailService */
    private BlockedEmailService $blockedEmailService;

    /**
     * EngellenenMailController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->blockedEmailService = new BlockedEmailService($request);
    }

    /**
     * @param IndexBlockedEmailRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexBlockedEmailRequest $request): PaginationResource
    {
        $blockedEmail = $this->blockedEmailService->index($request);

        return new PaginationResource($blockedEmail, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreBlockedEmailRequest  $request
     *
     * @return SuccessResource
     * @throws BlockedEmailAlreadyHaveException
     */
    public function store(StoreBlockedEmailRequest $request): SuccessResource
    {
        $this->blockedEmailService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws BlockedEmailNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->blockedEmailService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
