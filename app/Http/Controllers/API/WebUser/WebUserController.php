<?php

namespace App\Http\Controllers\API\WebUser;

use App\Exceptions\WebUser\WebUserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebUser\IndexWebUserRequest;
use App\Http\Resources\WebUser\WebUserCollection;
use App\Http\Resources\WebUser\WebUserResource;
use App\Services\WebUser\WebUserService;

/**
 * Class WebUserController
 *
 * @package App\Http\Controllers\API\WebUser
 */
class WebUserController extends Controller
{
    /** @var WebUserService $webUserService */
    private WebUserService $webUserService;

    /**
     * WebUserController constructor
     */
    public function __construct()
    {
        $this->webUserService = new WebUserService();
    }

    /**
     * @param IndexWebUserRequest  $request
     *
     * @return WebUserCollection
     */
    public function index(IndexWebUserRequest $request): WebUserCollection
    {
        $webUsers = $this->webUserService->index($request);

        return new WebUserCollection($webUsers, 'WEB_USER.INDEX.SUCCESS');
    }

    /**
     * @param int  $id
     *
     * @return WebUserResource
     * @throws WebUserNotFoundException
     */
    public function show(int $id): WebUserResource
    {
        $webUser = $this->webUserService->show($id);

        return new WebUserResource($webUser, 'WEB_USER.SHOW.SUCCESS');
    }
}
