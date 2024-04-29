<?php

namespace App\Services\Reason;

use App\Enums\DefaultConstant;
use App\Models\Sebep\SebepIstenecekler;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class ReasonWantedService
 *
 * @package App\Service\Reason
 */
class ReasonWantedService
{
    /**
     * @param Request $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return SebepIstenecekler::limit(DefaultConstant::SEARCH_LIST_LIMIT)->get();
    }
}
