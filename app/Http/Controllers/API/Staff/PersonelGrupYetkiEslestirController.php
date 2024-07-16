<?php

namespace App\Http\Controllers\API\Staff;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Staff\StaffGroupAuthorizationMatchNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\BulkStaffGroupAuthorizationMatchRequest;
use App\Http\Requests\Staff\DestroyStaffGroupAuthorizationMatchRequest;
use App\Http\Requests\Staff\StoreStaffGroupAuthorizationMatchRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Staff\StaffGroupAuthorizationMatchService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class PersonelGrupYetkiEslestirController
 *
 * @package App\Http\Controllers\API\Staff
 */
class PersonelGrupYetkiEslestirController extends Controller
{
    /** @var StaffGroupAuthorizationMatchService $staffGroupAuthorizationMatchService */
    private StaffGroupAuthorizationMatchService $staffGroupAuthorizationMatchService;

    /**
     * PersonelGrupYetkiEslestirController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->staffGroupAuthorizationMatchService = new StaffGroupAuthorizationMatchService($request);
    }

    /**
     * @param StoreStaffGroupAuthorizationMatchRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function store(StoreStaffGroupAuthorizationMatchRequest $request): SuccessResource
    {
        $this->staffGroupAuthorizationMatchService->store($request);

        return new SuccessResource('STAFF_GROUP_AUTHORIZATION_MATCH.CREATE.SUCCESS');
    }

    /**
     * @param DestroyStaffGroupAuthorizationMatchRequest  $request
     *
     * @return SuccessResource
     * @throws StaffGroupAuthorizationMatchNotFoundException
     */
    public function destroy(DestroyStaffGroupAuthorizationMatchRequest $request): SuccessResource
    {
        $this->staffGroupAuthorizationMatchService->destroy($request);

        return new SuccessResource('STAFF_GROUP_AUTHORIZATION_MATCH.DESTROY.SUCCESS');
    }

    /**
     * @param BulkStaffGroupAuthorizationMatchRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function bulk(BulkStaffGroupAuthorizationMatchRequest $request): SuccessResource
    {
        $this->staffGroupAuthorizationMatchService->bulk($request);

        return new SuccessResource('STAFF_GROUP_AUTHORIZATION_MATCH.BULK.SUCCESS');
    }
}
