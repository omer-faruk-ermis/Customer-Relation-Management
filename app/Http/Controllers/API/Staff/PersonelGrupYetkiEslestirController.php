<?php

namespace App\Http\Controllers\API\Staff;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Staff\StaffGroupAuthorizationMatchNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreStaffGroupAuthorizationMatchRequest;
use App\Http\Resources\Staff\StaffGroupAuthorizationMatchResource;
use App\Http\Resources\SuccessResource;
use App\Services\Staff\StaffGroupAuthorizationMatchService;
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
     * @return StaffGroupAuthorizationMatchResource
     */
    public function store(StoreStaffGroupAuthorizationMatchRequest $request): StaffGroupAuthorizationMatchResource
    {
        $staffGroupAuthorizationMatch = $this->staffGroupAuthorizationMatchService->store($request);

        return new StaffGroupAuthorizationMatchResource($staffGroupAuthorizationMatch, 'STAFF_GROUP_AUTHORIZATION_MATCH.CREATE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws StaffGroupAuthorizationMatchNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->staffGroupAuthorizationMatchService->destroy($id);

        return new SuccessResource('STAFF_GROUP_AUTHORIZATION_MATCH.DESTROY.SUCCESS');
    }
}
