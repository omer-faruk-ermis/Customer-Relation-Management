<?php

namespace App\Services\WebUser;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Exceptions\WebUser\WebUserNotFoundException;
use App\Http\Requests\WebUser\IndexWebUserRequest;
use App\Models\WebUser\WebUser;
use App\Services\AbstractService;
use App\Utils\Security;

/**
 * Class WebUserService
 *
 * @package App\Service\WebUser
 */
class WebUserService extends AbstractService
{
    protected array $serviceName = [AuthorizationTypeName::SMS_MANAGEMENT => SmsManagement::USER_OPERATIONS];

    /**
     * @param IndexWebUserRequest  $request
     *
     * @return mixed
     */
    public function index(IndexWebUserRequest $request): mixed
    {
        $webUser = WebUser::getModel();

        return $webUser->filter($request->all())
                       ->select([
                                    $webUser->getQualifiedKeyName(),
                                    $webUser->qualifyColumn('ad'),
                                    $webUser->qualifyColumn('soyad'),
                                    $webUser->qualifyColumn('ceptel'),
                                    $webUser->qualifyColumn('kullanici_tipi'),
                                    $webUser->qualifyColumn('tckimlik'),
                                    $webUser->qualifyColumn('abone_no'),
                                    $webUser->qualifyColumn('abonetip'),
                                    $webUser->qualifyColumn('kurumadi'),
                                ])
                       ->orderByRaw('ad', 'COLLATE Turkish_CI_AS')
                       ->orderByRaw('soyad', 'COLLATE Turkish_CI_AS')
                       ->orderByRaw('kurumadi', 'COLLATE Turkish_CI_AS')
                       ->limit(DefaultConstant::SEARCH_LIST_LIMIT)
                       ->get();
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
