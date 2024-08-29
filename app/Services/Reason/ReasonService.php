<?php

namespace App\Services\Reason;

use App\Enums\DefaultConstant;
use App\Models\Sebep\Sebepler;
use App\Services\AbstractService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class ReasonService
 *
 * @package App\Service\Reason
 */
class ReasonService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     * @throws Exception
     */
    public function index(Request $request): Collection
    {
        return Sebepler::limit(DefaultConstant::SEARCH_LIST_LIMIT)->get();
    }
}
