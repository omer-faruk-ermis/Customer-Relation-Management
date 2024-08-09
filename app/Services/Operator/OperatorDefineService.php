<?php

namespace App\Services\Operator;

use App\Enums\NumericalConstant;
use App\Models\Operator\OperatorTanimlari;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class OperatorDefineService
 *
 * @package App\Service\Authorization
 */
class OperatorDefineService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return OperatorTanimlari::where('abonecdrbildir', NumericalConstant::TRUE)
                                ->get();
    }
}
