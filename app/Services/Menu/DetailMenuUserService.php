<?php

namespace App\Services\Menu;

use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\DetailMenu\DetailMenuUserNotFoundException;
use App\Models\Menu\DetayMenuUser;
use App\Utils\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class DetayMenuUserService
 *
 * @package App\Service\Menu
 */
class DetailMenuUserService
{
    /**
     * @param Request  $request
     *
     * @return void
     */
    public function store(Request $request): void
    {
        DetayMenuUser::create([
                                  'menu_id'   => $request->input('menu_id'),
                                  'userid'    => $request->input('employee_id'),
                                  'kayit_tar' => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
                                  'kayit_id'  => Cache::get("sms_kimlik_$request->input('netgsmsessionid')"),
                                  'kayit_ip'  => $request->ip(),
                                  'durum'     => Status::ACTIVE,
                              ]);
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws DetailMenuUserNotFoundException
     */
    public function destroy(string $id): void
    {
        $detailMenuUser = DetayMenuUser::find(Security::decrypt($id));
        if (empty($detailMenuUser)) {
            throw new DetailMenuUserNotFoundException();
        }

        $detailMenuUser->durum = Status::PASSIVE;
        $detailMenuUser->update();
    }
}
