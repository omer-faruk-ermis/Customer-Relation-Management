<?php

namespace App\Services\Menu;

use App\Enums\Status;
use App\Models\Menu\MenuTanim;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class MenuDefinitionService
 *
 * @package App\Service\Menu
 */
class MenuDefinitionService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function menu(Request $request): Collection
    {
      return MenuTanim::with(['pages'])
                        ->where('durum', '=', Status::ACTIVE)
                        ->orderBy('sira')
                        ->get();
    }
}
