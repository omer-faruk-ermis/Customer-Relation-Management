<?php

namespace App\Http\Controllers\API\Reason;

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
     */
    public function __construct()
    {
        $this->reasonService = new ReasonService();
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

        return new ReasonCollection($reasons, 'REASON.INDEX.SUCCESS');
    }
}
