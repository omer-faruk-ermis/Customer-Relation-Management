<?php

namespace App\Http\Controllers\API\Staff;

use App\Exceptions\Staff\StaffGroupAuthorizationMatchNotFoundException;
use App\Exceptions\Staff\StaffGroupMatchNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreStaffGroupRequest;
use App\Http\Resources\Staff\StaffGroupAuthorizationMatchResource;
use App\Http\Resources\Staff\StaffGroupMatchResource;
use App\Http\Resources\SuccessResource;
use App\Services\Staff\StaffGroupAuthorizationMatchService;
use App\Services\Staff\StaffGroupMatchService;

/**
 * Class PersonelGrupEslestirController
 *
 * @package App\Http\Controllers\API\Staff
 */
class PersonelGrupEslestirController extends Controller
{
    /** @var StaffGroupMatchService $staffGroupMatchService */
    private StaffGroupMatchService $staffGroupMatchService;

    /**
     * PersonelGrupEslestirController constructor
     */
    public function __construct()
    {
        $this->staffGroupMatchService = new StaffGroupMatchService();
    }

    /**
     * @param StoreStaffGroupRequest  $request
     *
     * @return StaffGroupMatchResource
     */
    public function store(StoreStaffGroupRequest $request): StaffGroupMatchResource
    {
        $staffGroupMatch = $this->staffGroupMatchService->store($request);

        return new StaffGroupMatchResource($staffGroupMatch, 'STAFF_GROUP_MATCH.CREATE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws StaffGroupMatchNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->staffGroupMatchService->destroy($id);

        return new SuccessResource('STAFF_GROUP_MATCH.DESTROY.SUCCESS');
    }
}
