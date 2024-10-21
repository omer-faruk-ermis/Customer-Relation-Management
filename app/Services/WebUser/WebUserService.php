<?php

namespace App\Services\WebUser;

use App\Constants\WidgetId;
use App\Enums\DefaultConstant;
use App\Exceptions\WebUser\WebUserNotFoundException;
use App\Models\Subscriber\AboneNo;
use App\Models\Subscriber\AboneNoThk;
use App\Models\WebUser\WebUser;
use App\Models\WebUser\WebUserKullaniciTipleri;
use App\Services\AbstractService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class WebUserService
 *
 * @package App\Service\WebUser
 */
class WebUserService extends AbstractService
{
    protected array $privateMethods = [
        'index' => WidgetId::GENERAL_SEARCH,
        'type'  => WidgetId::GENERAL_SEARCH
    ];

    /**
     * @param Request  $request
     *
     * @return Collection|LengthAwarePaginator
     */
    public function index(Request $request): Collection|LengthAwarePaginator
    {
        $webUserModel = WebUser::getModel();

        // TODO: NEED REFACTOR
        $webUserSelect = [$webUserModel->qualifyAllColumns(), 'aboneNoThk.' . DefaultConstant::ALL_COLUMN];
        $selectUserTypeOthers = ['id', 'userid', 'durum', 'telno'];
        $selectUserType12 = ['id as idx', 'userid as useridx', 'durum as durumx', 'telno'];

        $webUser = WebUser::with([
                                     'userType',
                                     'corporationType',
                                     'simCard',
                                     'subscriberNo',
                                     'dealer',
                                     'special',
                                     'vip',
                                     'pilot'
                                 ])
                          ->select($webUserSelect)
                          ->when($request->input('user_type') == 12, function ($q) use ($selectUserType12) {
                              $q->leftJoinSub(function ($query) use ($selectUserType12) {
                                  $query->select($selectUserType12)
                                        ->from(AboneNoThk::getModel()->getTable());
                              }, 'aboneNoThk', function ($join) {
                                  $join->on('aboneNoThk.useridx', '=', WebUser::getModel()->getQualifiedKeyName());
                              });
                          }, function ($q) use ($selectUserTypeOthers, $selectUserType12) {
                              $q->leftJoinSub(function ($query) use ($selectUserTypeOthers, $selectUserType12) {
                                  $query->select($selectUserType12)
                                        ->fromSub(function ($sub) use ($selectUserTypeOthers) {
                                            $sub->select($selectUserTypeOthers)->from(AboneNo::getModel()->getTable())
                                                ->union(DB::table(AboneNoThk::getModel()->getTable())
                                                          ->select($selectUserTypeOthers)
                                                );
                                        }, 'aboneNoThk');
                              }, 'aboneNoThk', function ($join) {
                                  $join->on('aboneNoThk.useridx', '=', WebUser::getModel()->getQualifiedKeyName());
                              });
                          })
                          ->filter($request->all())
                          ->orderByRaw('ad', 'COLLATE Turkish_CI_AS')
                          ->orderByRaw('soyad', 'COLLATE Turkish_CI_AS')
                          ->orderByRaw('kurumadi', 'COLLATE Turkish_CI_AS');


        return $request->input('page')
            ? $webUser->paginate(DefaultConstant::PAGINATE_FOR_MODAL)
            : $webUser->limit(DefaultConstant::SEARCH_LIST_LIMIT)->get();
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
        $webUser = WebUser::find($id);
        if (empty($webUser)) {
            throw new WebUserNotFoundException();
        }

        return $webUser;
    }
}
