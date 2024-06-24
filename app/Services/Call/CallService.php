<?php

namespace App\Services\Call;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Enums\UserType;
use App\Helpers\QueryBuilder;
use App\Models\Call\Cagri;
use App\Models\Customer\Musteri;
use App\Models\Voice\SesUser;
use App\Models\WebUser\WebUser;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class CallService
 *
 * @package App\Service\Call
 */
class CallService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::DEFINE_REASON
        ],
    ];

    /**
     * @param Request  $request
     *
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $userPhone = $request->input('user_phone');
        $userName = $request->input('user_name');

        $cagri = Cagri::getModel();
        $sesUser = SesUser::getModel();
        $musteri = Musteri::getModel();
        $webUser = WebUser::getModel();

        $subQuery = Cagri::select([

                                      $cagri->qualifyColumn('id'),
                                      $cagri->qualifyColumn('id') . ' as cagri_id',
                                      $cagri->qualifyColumn('cagri_yonu'),
                                      $cagri->qualifyColumn('cid') . ' as cagri_tel',
                                      $cagri->qualifyColumn('bas_tar'),
                                      $cagri->qualifyColumn('bit_tar'),
                                      $cagri->qualifyColumn('opid'),
                                      $cagri->qualifyColumn('seskayit'),
                                      $cagri->qualifyColumn('billsec'),
                                      $cagri->qualifyColumn('sube') . ' as cagri_sube',
                                      DB::raw('(CASE WHEN ' . $sesUser->qualifyColumn('kul_tur') . ' = ' . UserType::CUSTOMER .
                                              ' THEN \'Customer\'
                                              ELSE \'Subscriber\'
                                                    END) as user_type'),
                                      DB::raw('(CASE WHEN ' . $sesUser->qualifyColumn('kul_tur') . ' = ' . UserType::CUSTOMER .
                                              ' THEN ' . $musteri->qualifyColumn('ad') . '
                                              ELSE ' . $webUser->qualifyColumn('ad') . '
                                                    END) as user_name'),
                                      DB::raw('(CASE WHEN ' . $sesUser->qualifyColumn('kul_tur') . ' = ' . UserType::CUSTOMER .
                                              ' THEN ' . $musteri->qualifyColumn('cep_tel') . '
                                              ELSE ' . $webUser->qualifyColumn('ceptel') . '
                                                    END) as user_phone'),
                                  ])
                         ->join(
                             $sesUser->getTable(),
                             $cagri->getQualifiedKeyName(),
                             '=',
                             $sesUser->qualifyColumn('cagri_id'))
                         ->leftJoin($musteri->getTable(), function ($join) use ($sesUser, $musteri) {
                             $join->on($sesUser->qualifyColumn('userid'),
                                       '=',
                                       $musteri->getQualifiedKeyName())
                                  ->where($musteri->qualifyColumn('durum'), Status::ACTIVE)
                                  ->where($sesUser->qualifyColumn('kul_tur'), '=', UserType::CUSTOMER);
                         })
                         ->leftJoin($webUser->getTable(), function ($join) use ($sesUser, $webUser) {
                             $join->on($sesUser->qualifyColumn('userid'),
                                       '=',
                                       $webUser->getQualifiedKeyName())
                                  ->where($sesUser->qualifyColumn('kul_tur'), '<>', UserType::CUSTOMER);
                         })
                         ->filter($request->all());

        $query = QueryBuilder::createSubQuery($subQuery)
                             ->when(!is_null($userName), function ($q) use ($userName) {
                                 $q->WHERE('user_name', 'LIKE', '%' . $userName . '%');
                             })
                             ->when(!is_null($userPhone), function ($q) use ($userPhone) {
                                 $q->WHERE('user_phone', 'LIKE', '%' . $userPhone . '%');
                             })
                             ->paginate(DefaultConstant::PAGINATE);

        $models = QueryBuilder::convertToModels($query, Cagri::class);

        return QueryBuilder::reloadRelations($models, ['operator.sip', 'voiceUser.pairedBy']);
    }
}
