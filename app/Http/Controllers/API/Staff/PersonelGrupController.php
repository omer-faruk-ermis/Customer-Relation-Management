<?php

namespace App\Http\Controllers\API\Staff;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Staff\StaffGroupNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\IndexStaffGroupRequest;
use App\Http\Requests\Staff\StoreStaffGroupRequest;
use App\Http\Requests\Staff\UpdateStaffGroupRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\Staff\StaffGroupResource;
use App\Http\Resources\SuccessResource;
use App\Services\Staff\StaffGroupService;
use Illuminate\Http\Request;

/**
 * Class PersonelGrupController
 *
 * @package App\Http\Controllers\API\Staff
 */
class PersonelGrupController extends Controller
{
    /** @var StaffGroupService $staffGroupService */
    private StaffGroupService $staffGroupService;

    /**
     * PersonelGrupController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->staffGroupService = new StaffGroupService($request);
    }

    /**
     * @param IndexStaffGroupRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexStaffGroupRequest $request): PaginationResource
    {
        $staffGroup = $this->staffGroupService->index($request);

        return new PaginationResource($staffGroup, 'STAFF_GROUP.INDEX.SUCCESS');
    }

    /**
     * @param StoreStaffGroupRequest  $request
     *
     * @return StaffGroupResource
     */
    public function store(StoreStaffGroupRequest $request): StaffGroupResource
    {
        $staffGroup = $this->staffGroupService->store($request);

        return new StaffGroupResource($staffGroup, 'STAFF_GROUP.CREATE.SUCCESS');
    }

    /**
     * @param UpdateStaffGroupRequest  $request
     * @param string                   $id
     *
     * @return StaffGroupResource
     *
     * @throws StaffGroupNotFoundException
     */
    public function update(UpdateStaffGroupRequest $request, string $id): StaffGroupResource
    {
        $staffGroup = $this->staffGroupService->update($request, $id);

        return new StaffGroupResource($staffGroup, 'STAFF_GROUP.UPDATE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws StaffGroupNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->staffGroupService->destroy($id);

        return new SuccessResource('STAFF_GROUP.DESTROY.SUCCESS');
    }
}
