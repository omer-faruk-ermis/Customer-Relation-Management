<?php

namespace App\Services\WebPortal;

use App\Models\WebPortal\WebPortalYetki;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class WebPortalAuthorizationService
 *
 * @package App\Service\WebPortal
 */
class WebPortalAuthorizationService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function menu(Request $request): Collection
    {
        return WebPortalYetki::with('members')
                             ->filter($request->all())
                             ->active()
                             ->whereNotNull('yetki_detay')
                             ->whereNotNull('menu_id')
                             ->whereNotNull('tip')
                             ->get()
                             ->groupBy('tanim');
    }

    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function page(Request $request): Collection
    {
        return WebPortalYetki::with('members')
                             ->filter($request->all())
                             ->active()
                             ->whereNotNull('yetki_detay')
                             ->whereNotNull('menu_id')
                             ->whereNotNull('tip')
                             ->get();
    }
}
