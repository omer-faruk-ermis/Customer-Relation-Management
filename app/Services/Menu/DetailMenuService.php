<?php

namespace App\Services\Menu;

use App\Enums\DefaultConstant;
use App\Models\Menu\DetayMenu;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class DetailMenuService
 *
 * @package App\Service\Menu
 */
class DetailMenuService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function menu(Request $request): Collection
    {
        return DetayMenu::with([
                                   'pages.detail.members',
                                   'detail.members'
                               ])
                        ->active()
                        ->where('parentid', '=', DefaultConstant::PARENT)
                        ->orderBy('sira')
                        ->get();
    }

    /**
     * @param Request  $request
     *
     * @return Collection
     *
     */
    public function page(Request $request): Collection
    {
        return DetayMenu::with(['detail.members'])
                        ->active()
                        ->where('parentid', '<>', DefaultConstant::PARENT)
                        ->orderBy('sira')
                        ->get();
    }
}
