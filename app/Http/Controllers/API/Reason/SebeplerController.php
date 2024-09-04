<?php

namespace App\Http\Controllers\API\Reason;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Reason\ReasonCollection;
use App\Services\Reason\ReasonService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class SebeplerController
 *
 * @package App\Http\Controllers\API\Reason
 */
class SebeplerController extends Controller
{
    /** @var ReasonService $reasonService */
    private ReasonService $reasonService;

    /**
     * SebeplerController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->reasonService = new ReasonService($request);
    }

    /**
     * @param Request  $request
     *
     * @return ReasonCollection
     * @throws Exception
     */
    public function index(Request $request): ReasonCollection
    {
        $reasons = $this->reasonService->index($request);

        return new ReasonCollection($reasons, __('messages.' . self::class . '.INDEX'));
    }
}
