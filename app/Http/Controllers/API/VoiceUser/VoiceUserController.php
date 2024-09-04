<?php

namespace App\Http\Controllers\API\VoiceUser;

use App\Exceptions\Call\CallNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\Voice\VoiceUserNotFoundException;
use App\Exceptions\WebUser\WebUserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoiceUser\LastPairVoiceUserRequest;
use App\Http\Requests\VoiceUser\PathVoiceUserRequest;
use App\Http\Requests\VoiceUser\StoreVoiceUserRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\VoiceUser\PathResource;
use App\Http\Resources\WebUser\WebUserCollection;
use App\Services\VoiceUser\VoiceUserService;
use Illuminate\Http\Request;

/**
 * Class VoiceUserController
 *
 * @package App\Http\Controllers\API\VoiceUser
 */
class VoiceUserController extends Controller
{
    /** @var VoiceUserService $voiceUserService */
    private VoiceUserService $voiceUserService;

    /**
     * VoiceUserController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->voiceUserService = new VoiceUserService($request);
    }

    /**
     * @param StoreVoiceUserRequest  $request
     *
     * @return SuccessResource
     * @throws CallNotFoundException
     * @throws WebUserNotFoundException
     */
    public function store(StoreVoiceUserRequest $request): SuccessResource
    {
        $this->voiceUserService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.STORE'));
    }

    /**
     * @param PathVoiceUserRequest  $request
     *
     * @return PathResource
     */
    public function path(PathVoiceUserRequest $request): PathResource
    {
        $path = $this->voiceUserService->path($request);

        return new PathResource($path, __('messages.' . self::class . '.PATH'));
    }

    /**
     * @param LastPairVoiceUserRequest  $request
     *
     * @return WebUserCollection
     */
    public function lastPair(LastPairVoiceUserRequest $request): WebUserCollection
    {
        $lastPairUsers = $this->voiceUserService->lastPair($request);

        return new WebUserCollection($lastPairUsers, __('messages.' . self::class . '.LAST_PAIR_USER'));
    }

    /**
     * @param $id
     *
     * @return SuccessResource
     * @throws VoiceUserNotFoundException
     */
    public function destroy($id): SuccessResource
    {
        $this->voiceUserService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
