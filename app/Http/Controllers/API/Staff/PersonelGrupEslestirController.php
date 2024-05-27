<?php

namespace App\Http\Controllers\API\Staff;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Staff\StaffGroupMatchNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreStaffGroupMatchRequest;
use App\Http\Resources\Staff\StaffGroupMatchResource;
use App\Http\Resources\SuccessResource;
use App\Services\Staff\StaffGroupMatchService;
use Illuminate\Http\Request;

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
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->staffGroupMatchService = new StaffGroupMatchService($request);
    }

    /**
     * @param StoreStaffGroupMatchRequest  $request
     *
     * @return StaffGroupMatchResource
     */
    public function store(StoreStaffGroupMatchRequest $request): StaffGroupMatchResource
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
