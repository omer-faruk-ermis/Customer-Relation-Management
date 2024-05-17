<?php

namespace App\Services\WebPortal;

use App\Enums\Status;
use App\Models\WebPortal\WebPortalYetki;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class WebPortalAuthorizationService
 *
 * @package App\Service\WebPortal
 */
class WebPortalAuthorizationService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return WebPortalYetki::where('durum', '=', Status::ACTIVE)->get();
    }
}
