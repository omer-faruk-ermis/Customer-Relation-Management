<?php

namespace App\Services\Strategies;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\BlueScreen;
use App\Enums\Status;
use App\Exceptions\ForbiddenException;
use App\Models\Menu\DetayMenu;
use App\Models\Menu\DetayMenuUser;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class BlueScreenStrategy implements PermissionStrategy
{
    /**
     * @param Request  $request
     * @param array    $authorizationIds
     * @param array    $authorizations
     *
     * @return bool
     * @throws ForbiddenException
     */
    public function check(Request $request, array $authorizationIds, array $authorizations): bool
    {
        if (Arr::get($authorizations, AuthorizationTypeName::BLUE_SCREEN) && !empty($authorizationIds)) {
            if (BlueScreen::hasValue($authorizations[AuthorizationTypeName::BLUE_SCREEN])
                && !empty(array_intersect($authorizations[AuthorizationTypeName::BLUE_SCREEN], $authorizationIds[AuthorizationTypeName::BLUE_SCREEN]))) {

                $url = DetayMenu::where('menu_url', $request->input('url'))
                                ->whereIn('id', $authorizations[AuthorizationTypeName::BLUE_SCREEN])
                                ->where('durum', Status::ACTIVE)
                                ->first();

                if ($url && DetayMenuUser::where('menu_id', $url->id)
                                         ->where('userid', Auth::id())
                                         ->where('durum', Status::ACTIVE)
                                         ->exists()) {
                    return true;
                }
            }

            throw new ForbiddenException();
        }

        return true;
    }
}
