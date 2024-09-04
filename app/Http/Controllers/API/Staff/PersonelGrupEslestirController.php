<?php

namespace App\Http\Controllers\API\Staff;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Staff\StaffGroupMatchAlreadyHaveException;
use App\Exceptions\Staff\StaffGroupMatchNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\BulkStaffGroupMatchRequest;
use App\Http\Requests\Staff\DestroyStaffGroupMatchRequest;
use App\Http\Requests\Staff\StoreStaffGroupMatchRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Staff\StaffGroupMatchService;
use Exception;
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
     * @return SuccessResource
     * @throws StaffGroupMatchAlreadyHaveException
     */
    public function store(StoreStaffGroupMatchRequest $request): SuccessResource
    {
        $this->staffGroupMatchService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws StaffGroupMatchNotFoundException
     */
    public function destroyStaff(string $id): SuccessResource
    {
        $this->staffGroupMatchService->destroyStaff($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }

    /**
     * @param DestroyStaffGroupMatchRequest  $request
     *
     * @return SuccessResource
     * @throws StaffGroupMatchNotFoundException
     */
    public function destroy(DestroyStaffGroupMatchRequest $request): SuccessResource
    {
        $this->staffGroupMatchService->destroy($request);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }

    /**
     * @param BulkStaffGroupMatchRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function bulk(BulkStaffGroupMatchRequest $request): SuccessResource
    {
        $this->staffGroupMatchService->bulk($request);

        return new SuccessResource(__('messages.' . self::class . '.BULK'));
    }
}
