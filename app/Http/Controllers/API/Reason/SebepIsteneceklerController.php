<?php

namespace App\Http\Controllers\API\Reason;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Reason\ReasonWantedCollection;
use App\Services\Reason\ReasonWantedService;
use Illuminate\Http\Request;

/**
 * Class SebepIsteneceklerController
 *
 * @package App\Http\Controllers\API\Reason
 */
class SebepIsteneceklerController extends Controller
{
    /** @var ReasonWantedService $reasonWantedService */
    private ReasonWantedService $reasonWantedService;

    /**
     * SebepIsteneceklerController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->reasonWantedService = new ReasonWantedService($request);
    }

    /**
     * @param Request $request
     *
     * @return ReasonWantedCollection
     */
    public function index(Request $request): ReasonWantedCollection
    {
        $reasonWanteds = $this->reasonWantedService->index($request);

        return new ReasonWantedCollection($reasonWanteds, 'REASON_WANTED.INDEX.SUCCESS');
    }
}
