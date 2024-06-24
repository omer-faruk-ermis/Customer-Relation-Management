<?php

namespace App\Http\Controllers\API\WebUser;

use App\Exceptions\ForbiddenException;
use App\Exceptions\WebUser\WebUserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebUser\IndexWebUserRequest;
use App\Http\Requests\WebUser\IndexWebUserTypeRequest;
use App\Http\Resources\SuccessDataResource;
use App\Http\Resources\WebUser\WebUserCollection;
use App\Http\Resources\WebUser\WebUserResource;
use App\Services\WebUser\WebUserService;
use Illuminate\Http\Request;

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
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->webUserService = new WebUserService($request);
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
     * @param IndexWebUserTypeRequest  $request
     *
     * @return SuccessDataResource
     */
    public function type(IndexWebUserTypeRequest $request): SuccessDataResource
    {
        $webUserTypes = $this->webUserService->type($request);

        return new SuccessDataResource($webUserTypes, 'WEB_USER.TYPE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return WebUserResource
     * @throws WebUserNotFoundException
     */
    public function show(string $id): WebUserResource
    {
        $webUser = $this->webUserService->show($id);

        return new WebUserResource($webUser, 'WEB_USER.SHOW.SUCCESS');
    }
}
