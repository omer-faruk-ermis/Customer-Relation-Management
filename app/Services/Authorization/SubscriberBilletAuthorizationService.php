<?php

namespace App\Services\Authorization;

use App\Enums\Authorization\AuthorizationTypeTrName;
use App\Models\Authorization\AboneKutukYetkileri;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class SubscriberBilletAuthorizationService
 *
 * @package App\Service\Authorization
 */
class SubscriberBilletAuthorizationService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return object
     */
    public function menu(Request $request): object
    {
        return (object)[
            'name'  => AuthorizationTypeTrName::SUBSCRIBER_BILLET,
            'pages' => AboneKutukYetkileri::active()->get()];
    }

    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function page(Request $request): Collection
    {
        return AboneKutukYetkileri::with('menu')->active()->get();
    }
}
