<?php

namespace App\Services\WebUser;

use App\Enums\DefaultConstant;
use App\Exceptions\WebUser\WebUserNotFoundException;
use App\Models\Subscriber\AboneNo;
use App\Models\Subscriber\AboneNoThk;
use App\Models\WebUser\WebUser;
use App\Models\WebUser\WebUserKullaniciTipleri;
use App\Services\AbstractService;
use App\Utils\Security;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class WebUserService
 *
 * @package App\Service\WebUser
 */
class WebUserService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $webUserSelect = [DefaultConstant::ALL_COLUMN, 'aboneNoThk.*'];
        $select = ['id', 'userid', 'durum', 'telno'];
        $selectX = ['id as idx', 'userid as useridx', 'durum as durumx', 'telno'];

        return WebUser::with(['userType', 'simCard'])
                      ->select($webUserSelect)
                      ->when($request->input('user_type') == 12, function ($q) use ($selectX) {
                          $q->leftJoinSub(function ($query) use ($selectX) {
                              $query->select($selectX)->from(AboneNoThk::getModel()->getTable());
                          }, 'aboneNoThk', function ($join) {
                              $join->on('aboneNoThk.useridx', '=', WebUser::getModel()->getQualifiedKeyName());
                          });
                      }, function ($q) use ($select, $selectX) {
                          $q->leftJoinSub(function ($query) use ($select, $selectX) {
                              $query->select($selectX)
                                    ->fromSub(function ($sub) use ($select) {
                                        $sub->select($select)->from(AboneNo::getModel()->getTable())
                                            ->union(DB::table(AboneNoThk::getModel()->getTable())
                                                      ->select($select)
                                            );
                                    }, 'aboneNoThk');
                          }, 'aboneNoThk', function ($join) {
                              $join->on('aboneNoThk.useridx', '=', WebUser::getModel()->getQualifiedKeyName());
                          });
                      })
                      ->filter($request->all())
                      ->orderByRaw('ad', 'COLLATE Turkish_CI_AS')
                      ->orderByRaw('soyad', 'COLLATE Turkish_CI_AS')
                      ->orderByRaw('kurumadi', 'COLLATE Turkish_CI_AS')
                      ->limit(DefaultConstant::SEARCH_LIST_LIMIT)
                      ->get();
    }

    /**
     * @param Request  $request
     *
     * @return array|Collection
     */
    public function type(Request $request): array|Collection
    {
        return WebUserKullaniciTipleri::get();
    }

    /**
     * @param string  $id
     *
     * @return WebUser
     * @throws WebUserNotFoundException
     */
    public function show(string $id): WebUser
    {
        $webUser = WebUser::find(Security::decrypt($id));
        if (empty($webUser)) {
            throw new WebUserNotFoundException();
        }

        return $webUser;
    }
}
