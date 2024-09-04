<?php

namespace App\Http\Controllers\API\Operator;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Operator\OperatorDefineCollection;
use App\Services\Operator\OperatorDefineService;
use Illuminate\Http\Request;

/**
 * Class OperatorTanimlariController
 *
 * @package App\Http\Controllers\API\Operator
 */
class OperatorTanimlariController extends Controller
{
    /** @var OperatorDefineService $operatorDefineService */
    private OperatorDefineService $operatorDefineService;

    /**
     * OperatorTanimlariController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->operatorDefineService = new OperatorDefineService($request);
    }

    /**
     * @param Request $request
     *
     * @return OperatorDefineCollection
     */
    public function index(Request $request): OperatorDefineCollection
    {
        $operatorDefines = $this->operatorDefineService->index($request);

        return new OperatorDefineCollection($operatorDefines, __('messages.' . self::class . '.INDEX'));
    }
}
