<?php

namespace App\Http\Controllers\API\VoiceUser;

use App\Exceptions\Call\CallNotFoundException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\WebUser\WebUserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoiceUser\LastPairVoiceUserRequest;
use App\Http\Requests\VoiceUser\PathVoiceUserRequest;
use App\Http\Requests\VoiceUser\StoreVoiceUserRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\VoiceUser\LastPairCollection;
use App\Http\Resources\VoiceUser\LastPairResource;
use App\Http\Resources\VoiceUser\PathResource;
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

        return new SuccessResource('VOICE_USER.STORE.SUCCESS');
    }

    /**
     * @param PathVoiceUserRequest  $request
     *
     * @return PathResource
     */
    public function path(PathVoiceUserRequest $request): PathResource
    {
        $path = $this->voiceUserService->path($request);

        return new PathResource($path, 'VOICE_USER.PATH.SUCCESS');
    }

    /**
     * @param LastPairVoiceUserRequest  $request
     *
     * @return LastPairCollection
     */
    public function lastPair(LastPairVoiceUserRequest $request): LastPairCollection
    {
        $lastPairs = $this->voiceUserService->lastPair($request);

        return new LastPairCollection($lastPairs, 'VOICE_USER.LAST_PAIR.SUCCESS');
    }
}
