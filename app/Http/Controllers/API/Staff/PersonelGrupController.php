<?php

namespace App\Http\Controllers\API\Staff;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Staff\StaffGroupNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\IndexStaffGroupRequest;
use App\Http\Requests\Staff\ShowStaffGroupRequest;
use App\Http\Requests\Staff\StoreStaffGroupRequest;
use App\Http\Requests\Staff\UpdateStaffGroupRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\Staff\StaffGroupCollection;
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
     * @return StaffGroupCollection|PaginationResource
     */
    public function index(IndexStaffGroupRequest $request): StaffGroupCollection|PaginationResource
    {
        $staffGroup = $this->staffGroupService->index($request);

        return $request->input('page')
            ? new PaginationResource($staffGroup, __('messages.' . self::class . '.INDEX'))
            : new StaffGroupCollection($staffGroup, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param ShowStaffGroupRequest  $request
     * @param string                 $id
     *
     * @return StaffGroupResource
     * @throws StaffGroupNotFoundException
     */
    public function show(ShowStaffGroupRequest $request, string $id): StaffGroupResource
    {
        $staffGroup = $this->staffGroupService->show($request, $id);

        return new StaffGroupResource($staffGroup, __('messages.' . self::class . '.SHOW'));
    }

    /**
     * @param StoreStaffGroupRequest  $request
     *
     * @return StaffGroupResource
     */
    public function store(StoreStaffGroupRequest $request): StaffGroupResource
    {
        $staffGroup = $this->staffGroupService->store($request);

        return new StaffGroupResource($staffGroup, __('messages.' . self::class . '.CREATE'));
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

        return new StaffGroupResource($staffGroup, __('messages.' . self::class . '.UPDATE'));
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

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
