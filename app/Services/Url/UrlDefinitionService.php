<?php

namespace App\Services\Url;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\Url\HaveAlreadyUrlDefinitionException;
use App\Exceptions\Url\UrlDefinitionNotFoundException;
use App\Models\Url\UrlTanim;
use App\Services\AbstractService;
use App\Utils\Security;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * @return Collection|LengthAwarePaginator
     */
    public function page(Request $request): Collection|LengthAwarePaginator
    {
        $pages = UrlTanim::with(['recorder', 'menu', 'authorizations'])
                         ->filter($request->all())
                         ->active();

        return $request->input('page')
            ? $pages->paginate(DefaultConstant::PAGINATE)
            : $pages->get();
    }

    /**
     * @param Request  $request
     *
     * @return UrlTanim
     * @throws HaveAlreadyUrlDefinitionException
     */
    public function store(Request $request): UrlTanim
    {
        $urlDefinition =
            UrlTanim::with('menu')
                    ->filter($request->all())
                    ->active()
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
                                    'kayit_tarih' => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
                                ]);
    }

    /**
     * @param Request  $request
     * @param string   $id
     *
     * @return UrlTanim
     * @throws UrlDefinitionNotFoundException
     */
    public function update(Request $request, string $id): UrlTanim
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
