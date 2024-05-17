<?php

namespace App\Http\Controllers\API\Menu;

use App\Exceptions\DetailMenu\DetailMenuUserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailMenu\StoreDetailMenuUserRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Menu\DetailMenuUserService;

/**
 * Class DetayMenuUserController
 *
 * @package App\Http\Controllers\API\Menu
 */
class DetayMenuUserController extends Controller
{
    /** @var DetailMenuUserService $detailMenuUserService */
    private DetailMenuUserService $detailMenuUserService;

    /**
     * DetayMenuUserController constructor
     */
    public function __construct()
    {
        $this->detailMenuUserService = new DetailMenuUserService();
    }

    /**
     * @param StoreDetailMenuUserRequest  $request
     *
     * @return SuccessResource
     */
    public function store(StoreDetailMenuUserRequest $request): SuccessResource
    {
        $this->detailMenuUserService->store($request);

        return new SuccessResource('BLUE_SCREEN_AUTHORIZATION.CREATE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws DetailMenuUserNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->detailMenuUserService->destroy($id);

        return new SuccessResource('BLUE_SCREEN_AUTHORIZATION.DESTROY.SUCCESS');
    }
}
