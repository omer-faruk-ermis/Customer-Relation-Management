<?php

namespace App\Services\Url;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\Url\HaveAlreadyUrlDefinitionException;
use App\Exceptions\Url\UrlDefinitionNotFoundException;
use App\Http\Requests\Url\StoreUrlDefinitionRequest;
use App\Http\Requests\Url\UpdateUrlDefinitionRequest;
use App\Models\Url\UrlTanim;
use App\Services\AbstractService;
use App\Utils\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class UrlDefinitionService
 *
 * @package App\Service\Url
 */
class UrlDefinitionService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::AUTHORIZED_GROUPS,
            SmsManagement::AUTHORIZED_GROUPS_GROUP,
            SmsManagement::APP_MANAGEMENT,
            SmsManagement::APP_EMPLOYEE
        ]
    ];

    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function page(Request $request): Collection
    {
        return UrlTanim::with(['recorder', 'menu', 'authorizations'])
                       ->where('durum', '=', Status::ACTIVE)
                       ->get();
    }

    /**
     * @param StoreUrlDefinitionRequest  $request
     *
     * @return UrlTanim
     * @throws HaveAlreadyUrlDefinitionException
     */
    public function store(StoreUrlDefinitionRequest $request): UrlTanim
    {
        $urlDefinition =
            UrlTanim::with('menu')
                    ->filter($request)
                    ->where('durum', '=', Status::ACTIVE)
                    ->first();

        if (!empty($urlDefinition)) {
            throw new HaveAlreadyUrlDefinitionException();
        }

        return UrlTanim::create([
                                    'adi'         => $request->input('name'),
                                    'url'         => $request->input('url'),
                                    'ust_id'      => $request->input('menu_id'),
                                    'durum'       => Status::ACTIVE,
                                    'arkaplan_id' => $request->input('background_id'),
                                    'tab_id'      => NumericalConstant::ZERO,
                                    'kayit_id'    => Auth::id(),
                                    'kayit_ip'    => $request->ip(),
                                ]);
    }

    /**
     * @param UpdateUrlDefinitionRequest  $request
     * @param string                      $id
     *
     * @return UrlTanim
     * @throws UrlDefinitionNotFoundException
     */
    public function update(UpdateUrlDefinitionRequest $request, string $id): UrlTanim
    {
        $urlDefinition = UrlTanim::find(Security::decrypt($id));
        if (empty($urlDefinition)) {
            throw new UrlDefinitionNotFoundException();
        }

        $urlDefinition->update([
                                   'adi'         => $request->input('name'),
                                   'url'         => $request->input('url'),
                                   'ust_id'      => $request->input('menu_id'),
                                   'arkaplan_id' => $request->input('background_id')
                               ]);

        return $urlDefinition;
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws UrlDefinitionNotFoundException
     */
    public function destroy(string $id): void
    {
        $urlDefinition = UrlTanim::find(Security::decrypt($id));
        if (empty($urlDefinition)) {
            throw new UrlDefinitionNotFoundException();
        }

        $urlDefinition->durum = Status::PASSIVE;
        $urlDefinition->update();
    }
}
