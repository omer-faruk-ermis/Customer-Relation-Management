<?php

namespace App\Services\Menu;

use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Models\Menu\DetayMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class DetailMenuService
 *
 * @package App\Service\Menu
 */
class DetailMenuService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function menu(Request $request): Collection
    {
        return DetayMenu::with([
                                   'pages',
                                   'members'
                               ])
                        ->where('durum', '=', Status::ACTIVE)
                        ->where('parentid', '=', NumericalConstant::ZERO)
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
        return DetayMenu::with(['members'])
                        ->where('durum', '=', Status::ACTIVE)
                        ->where('parentid', '<>', NumericalConstant::ZERO)
                        ->orderBy('sira')
                        ->get();
    }
}
