<?php

namespace App\Services\WebUser;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\BlueScreen;
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
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::BLUE_SCREEN => [
            BlueScreen::USER_INFORMATION,
            BlueScreen::USER_MOVEMENTS,
        ],
    ];

    /**
     * @param IndexWebUserRequest  $request
     *
     * @return mixed
     */
    public function index(IndexWebUserRequest $request): mixed
    {
        return WebUser::select(DefaultConstant::ALL_COLUMN)
                      ->filter($request->all())
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
