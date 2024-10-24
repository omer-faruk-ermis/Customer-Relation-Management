<?php

namespace App\Services\Menu;

use App\Enums\Method;
use App\Enums\Status;
use App\Exceptions\DetailMenu\DetailMenuUserAlreadyHaveException;
use App\Exceptions\DetailMenu\DetailMenuUserNotFoundException;
use App\Helpers\CacheOperation;
use App\Models\Menu\DetayMenuUser;
use App\Services\AbstractService;
use App\Services\BulkAuthorizationTrait;
use App\Utils\DateUtil;
use App\Utils\RouteUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class DetayMenuUserService
 *
 * @package App\Service\Menu
 */
class DetailMenuUserService extends AbstractService
{
    use BulkAuthorizationTrait;

    /**
     * @param Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function store(Request $request): void
    {
        $detailMenuUser = DetayMenuUser::where('menu_id', '=', $request->input('authorization_id'))
                                       ->where('userid', '=', $request->input('employee_id'))
                                       ->active()
                                       ->first();

        if ($detailMenuUser) {
            throw new DetailMenuUserAlreadyHaveException();
        }

        DetayMenuUser::create([
                                  'menu_id'   => $request->input('authorization_id'),
                                  'userid'    => $request->input('employee_id'),
                                  'durum'     => Status::ACTIVE,

                                  'kayit_id'  => Auth::id(),
                                  'kayit_tar' => DateUtil::now(),
                                  'kayit_ip'  => $request->ip(),
                              ]);

        if (Method::STORE === RouteUtil::currentRoute())
            CacheOperation::refreshEmployeeSession($request->bearerToken());
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws DetailMenuUserNotFoundException
     * @throws Exception
     */
    public function destroy(Request $request): void
    {
        $detailMenuUser = DetayMenuUser::where('menu_id', '=', $request->input('authorization_id'))
                                       ->where('userid', '=', $request->input('employee_id'))
                                       ->when(Method::DESTROY === RouteUtil::currentRoute(), function ($q) {
                                           $q->active();
                                       })
                                       ->first();

        if (empty($detailMenuUser)) {
            throw new DetailMenuUserNotFoundException();
        }

        $detailMenuUser->durum = Status::PASSIVE;
        $detailMenuUser->update();

        if (Method::DESTROY === RouteUtil::currentRoute())
            CacheOperation::refreshEmployeeSession($request->bearerToken());
    }
}
