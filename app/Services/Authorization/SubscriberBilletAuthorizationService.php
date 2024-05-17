<?php

namespace App\Services\Authorization;

use App\Enums\Status;
use App\Models\Authorization\AboneKutukYetkileri;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class SubscriberBilletAuthorizationService
 *
 * @package App\Service\Authorization
 */
class SubscriberBilletAuthorizationService
{
    /**
     * @param Request $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return AboneKutukYetkileri::where('durum', '=', Status::ACTIVE)->get();
    }
}
