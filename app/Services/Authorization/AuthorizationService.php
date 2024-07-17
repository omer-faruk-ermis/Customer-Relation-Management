<?php

namespace App\Services\Authorization;

use App\Enums\Authorization\AuthorizationType;
use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\AuthorizationTypeTrName;
use App\Enums\Authorization\AuthorizationUserType;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Models\Authorization\AboneKutukYetkileri;
use App\Models\Authorization\SmsKimlikYetki;
use App\Models\Menu\DetayMenu;
use App\Models\Menu\DetayMenuUser;
use App\Models\Menu\MenuTanim;
use App\Models\Staff\PersonelGrupEslestir;
use App\Models\Staff\PersonelGruplari;
use App\Models\Staff\PersonelGrupYetkiEslestir;
use App\Models\Url\UrlTanim;
use App\Models\WebPortal\WebPortalYetki;
use App\Models\WebPortal\WebPortalYetkiIzin;
use Illuminate\Support\Collection;

/**
 * Class AuthorizationService
 *
 * @package App\Service\Authorization
 */
class AuthorizationService
{
    private const AUTHORIZATION = 'authorization';
    private const PROCESS_AUTHORIZATION = 'process_authorization';
    private int $id;
    private int $pluck;

    /**
     * @param int   $id
     * @param bool  $pluck
     */
    public function __construct(int $id, bool $pluck = false)
    {
        $this->id = $id;
        $this->pluck = $pluck;
    }

    /**
     * @return array
     */
    public function getAuthorizationsGrouped(): array
    {
        return [
            AuthorizationTypeName::SMS_MANAGEMENT    => $this->mergeAuthorization($this->smsManagement(), AuthorizationType::SMS_MANAGEMENT),
            AuthorizationTypeName::BLUE_SCREEN       => $this->mergeAuthorization($this->blueScreen(), AuthorizationType::BLUE_SCREEN),
            AuthorizationTypeName::AUTHORIZATION     => $this->mergeAuthorization($this->authorization(), AuthorizationType::AUTHORIZATION),
            AuthorizationTypeName::SUBSCRIBER_BILLET => $this->mergeAuthorization($this->subscriberBillet(), AuthorizationType::SUBSCRIBER_BILLET),
        ];
    }

    /**
     * @return array
     */
    public function getAuthorizations(): array
    {
        return array_merge(
            $this->mergeAuthorization($this->smsManagement(), AuthorizationType::SMS_MANAGEMENT),
            [
                AuthorizationTypeName::BLUE_SCREEN       => $this->mergeAuthorization($this->blueScreen(), AuthorizationType::BLUE_SCREEN),
                AuthorizationTypeName::SUBSCRIBER_BILLET => $this->mergeAuthorization($this->subscriberBillet(), AuthorizationType::SUBSCRIBER_BILLET),
            ]
        );
    }

    /**
     * @return string
     */
    public function getAuthorizationString(): string
    {
        $authorization = (new self($this->id, true))->getAuthorizationsGrouped();

        $smsManagementIds = implode(',', $authorization[AuthorizationTypeName::SMS_MANAGEMENT]->toArray());
        $blueScreenIds = implode(',', $authorization[AuthorizationTypeName::BLUE_SCREEN]->toArray());
        $authorizationIds = implode(',', $authorization[AuthorizationTypeName::AUTHORIZATION]->toArray());
        $subscriberBilletIds = implode(',', $authorization[AuthorizationTypeName::SUBSCRIBER_BILLET]->toArray());

        return $smsManagementIds . '#' . $blueScreenIds . '#' . $authorizationIds . '#' . $subscriberBilletIds;
    }

    /**
     * @param string|null  $authorizationString
     *
     * @return array
     */
    public static function parseAuthorizationString(?string $authorizationString): array
    {
        if (is_null($authorizationString)) {
            return [];
        }

        $parts = explode('#', $authorizationString);
        return [
            AuthorizationTypeName::SMS_MANAGEMENT    => explode(',', $parts[0]),
            AuthorizationTypeName::BLUE_SCREEN       => explode(',', $parts[1]),
            AuthorizationTypeName::AUTHORIZATION     => explode(',', $parts[2]),
            AuthorizationTypeName::SUBSCRIBER_BILLET => explode(',', $parts[3]),
        ];
    }

    /**
     * @param string|null  $type
     *
     * @return array
     */
    protected function getProcessAuthorizations(string $type = null): array
    {
        // TODO: REFACTOR AND TEST THIS PART OF CODE

        $checkAuthorization = !empty($this->mergeAuthorization($this->authorization(), AuthorizationType::AUTHORIZATION));

        if (isset($this->mergeAuthorization($this->authorization(), AuthorizationType::AUTHORIZATION)[$type])) {
            $typeArray = $this->mergeAuthorization($this->authorization(), AuthorizationType::AUTHORIZATION)[$type];
        } else {
            $typeArray = [];
        }

        if (AuthorizationTypeTrName::SMS_MANAGEMENT === $type) {
            return UrlTanim::select([
                                        'id',
                                        'adi as name',
                                        'url',
                                        'ust_id'
                                    ])
                           ->with(['menu' => function ($q) {
                               $q->select([
                                              'id',
                                              'menu'
                                          ]);
                           }])
                           ->active()
                           ->whereIn('id',
                                     array_column($checkAuthorization ? $typeArray : [], 'menu_id'))
                           ->get()
                           ->groupBy('menu.menu')
                           ->toArray();
        }

        if (AuthorizationTypeTrName::BLUE_SCREEN === $type) {
            return DetayMenu::select([
                                         'id',
                                         'menu_adi as name',
                                         'menu_url as url',
                                         'parentid'
                                     ])
                            ->with(['menu' => function ($q) {
                                $q->select([
                                               'id',
                                               'menu_adi as menu'
                                           ]);
                            }])
                            ->active()
                            ->whereIn('id',
                                      array_column($checkAuthorization ? $typeArray : [], 'menu_id'))
                            ->get()
                            ->groupBy('menu.menu')
                            ->toArray();
        }
    }

    /**
     * @param array|Collection  $authorizations
     * @param int               $type
     *
     * @return Collection|array
     */
    protected function mergeAuthorization(array|Collection $authorizations, int $type): Collection|array
    {
        $employeeGroups = $this->authorizationGroup($type);

        if (AuthorizationType::SMS_MANAGEMENT == $type) {
            $employeeGroup = $this->authorizationMatch($this->smsManagement($employeeGroups), $authorizations);
            if ($this->pluck) {
                return $employeeGroup->pluck('id');
            }

            return $this->addProcessAuthorization($employeeGroup->groupBy('menu')->toArray(), $this->getProcessAuthorizations(AuthorizationTypeTrName::SMS_MANAGEMENT));
        } else if (AuthorizationType::BLUE_SCREEN == $type) {
            $employeeGroup = $this->authorizationMatch($this->blueScreen($employeeGroups), $authorizations);
            if ($this->pluck) {
                return $employeeGroup->pluck('id');
            }

            $employeeGroup = $employeeGroup->groupBy(fn($q) => $q->menu_id)
                                           ->mapWithKeys(fn($group) => [
                                               $group->first()->name => $group->first()->menu_id != NumericalConstant::ZERO ? $group : []
                                           ])
                                           ->toArray();

            return $this->addProcessAuthorization($employeeGroup, $this->getProcessAuthorizations(AuthorizationTypeTrName::BLUE_SCREEN));

        } else if (AuthorizationType::AUTHORIZATION == $type) {
            $employeeGroup = $this->authorizationMatch($this->authorization($employeeGroups), $authorizations);
            if ($this->pluck) {
                return $employeeGroup->pluck('id');
            }

            return $employeeGroup->groupBy('authorization')
                                 ->toArray();
        } else if (AuthorizationType::SUBSCRIBER_BILLET == $type) {
            $employeeGroup = $this->authorizationMatch($this->subscriberBillet($employeeGroups), $authorizations);
            if ($this->pluck) {
                return $employeeGroup->pluck('id');
            }

            return $employeeGroup->groupBy('menu')
                                 ->toArray();
        }
    }

    /**
     * @param Collection        $employeeGroup
     * @param array|Collection  $authorizations
     *
     * @return Collection
     */
    protected function authorizationMatch(Collection $employeeGroup, array|Collection $authorizations): Collection
    {
        $existingIds = $employeeGroup->pluck('id')->all();

        foreach ($authorizations as $authorization) {
            if (!in_array($authorization['id'], $existingIds)) {
                $employeeGroup->push($authorization);
                $existingIds[] = $authorization['id'];
            }
        }

        return $employeeGroup;
    }

    /**
     * @param array  $employeeGroups
     * @param array  $authorizations
     *
     * @return array
     */
    protected function addProcessAuthorization(array $employeeGroups, array $authorizations): array
    {
        foreach ($authorizations as $key => $authorization) {
            if (array_key_exists($key, $employeeGroups)) {
                $employeeGroups[$key] = array_merge(
                    [self::AUTHORIZATION => $employeeGroups[$key]],
                    [self::PROCESS_AUTHORIZATION => $authorization]
                );
            } else {
                $employeeGroups[$key] = array_merge(
                    [self::AUTHORIZATION => []],
                    [self::PROCESS_AUTHORIZATION => $authorization]
                );
            }
        }

        foreach ($employeeGroups as $key => $employeeGroup) {
            if (!array_key_exists(self::PROCESS_AUTHORIZATION, $employeeGroup)) {
                $employeeGroups[$key] = [
                    self::AUTHORIZATION         => $employeeGroup,
                    self::PROCESS_AUTHORIZATION => []
                ];
            }
        }

        return $employeeGroups;
    }

    /**
     * @param int  $type
     * @param int  $groupId
     *
     * @return array
     */
    public function authorizationGroup(int $type, int $groupId = NumericalConstant::ZERO): array
    {
        $personelGruplari = PersonelGruplari::getModel();
        $personelGruplariEslestir = PersonelGrupEslestir::getModel();
        $personelGrupYetkiEslestir = PersonelGrupYetkiEslestir::getModel();

        return PersonelGruplari::select([
                                            $personelGrupYetkiEslestir->qualifyColumn('yetki_id') . ' as authorization_id'
                                        ])
                               ->join($personelGruplariEslestir->getTable(),
                                      $personelGruplari->getQualifiedKeyName(),
                                      '=',
                                      $personelGruplariEslestir->qualifyColumn('personel_grup_id'))
                               ->join($personelGrupYetkiEslestir->getTable(),
                                      $personelGruplariEslestir->qualifyColumn('personel_grup_id'),
                                      '=',
                                      $personelGrupYetkiEslestir->qualifyColumn('personel_grup_id'))
                               ->where($personelGruplariEslestir->qualifyColumn('personel_id'), '=', $this->id)
                               ->where($personelGruplariEslestir->qualifyColumn('durum'), '=', Status::ACTIVE)
                               ->where($personelGrupYetkiEslestir->qualifyColumn('durum'), '=', Status::ACTIVE)
                               ->where($personelGrupYetkiEslestir->qualifyColumn('tip'), '=', $type)
                               ->when($groupId > NumericalConstant::ZERO,
                                   function ($q) use ($personelGruplari, $personelGrupYetkiEslestir, $groupId) {
                                       $q->where($personelGrupYetkiEslestir->qualifyColumn('personel_grup_id'), '=', $groupId)
                                         ->where($personelGruplari->qualifyColumn('durum'), '<>', Status::DESTROY);
                                   }, function ($q) use ($personelGruplari) {
                                       $q->where($personelGruplari->qualifyColumn('durum'), '=', Status::ACTIVE);
                                   })
                               ->distinct()
                               ->get()
                               ->pluck('authorization_id')
                               ->toArray();
    }

    /**
     * @param array  $ids
     * @param bool   $fullList
     *
     * @return Collection
     */
    public function smsManagement(array $ids = [], bool $fullList = false): Collection
    {
        $urlTanim = UrlTanim::getModel();
        $menuTanim = MenuTanim::getModel();
        $smsKimlikYetki = SmsKimlikYetki::getModel();

        return UrlTanim::select([
                                    $urlTanim->getQualifiedKeyName(),
                                    $urlTanim->qualifyColumn('ust_id') . ' as menu_id',
                                    $urlTanim->qualifyColumn('adi') . ' as name',
                                    $urlTanim->qualifyColumn('url'),
                                    $menuTanim->qualifyColumn('menu'),
                                ])
                       ->join($menuTanim->getTable(),
                              $urlTanim->qualifyColumn('ust_id'),
                              '=',
                              $menuTanim->getQualifiedKeyName())
                       ->when(!$fullList, function ($q) use ($smsKimlikYetki, $urlTanim, $ids) {
                           $q->when(empty($ids), function ($qq) use ($smsKimlikYetki, $urlTanim) {
                               $qq->join($smsKimlikYetki->getTable(),
                                         $urlTanim->getQualifiedKeyName(),
                                         '=',
                                         $smsKimlikYetki->qualifyColumn('url_id'))
                                  ->where($smsKimlikYetki->qualifyColumn('sms_kimlik'), '=', $this->id)
                                  ->where($smsKimlikYetki->qualifyColumn('durum'), '=', Status::ACTIVE);
                           }, function ($qq) use ($ids, $urlTanim) {
                               $qq->whereIn($urlTanim->getQualifiedKeyName(), $ids);
                           });
                       })
                       ->where($urlTanim->qualifyColumn('durum'), '=', Status::ACTIVE)
                       ->where($menuTanim->qualifyColumn('durum'), '=', Status::ACTIVE)
                       ->orderBy($menuTanim->qualifyColumn('sira'))
                       ->get();
    }

    /**
     * @param array  $ids
     * @param bool   $fullList
     *
     * @return Collection
     */
    public function blueScreen(array $ids = [], bool $fullList = false): Collection
    {
        $detailMenu = DetayMenu::getModel();
        $detailMenuUser = DetayMenuUser::getModel();

        return DetayMenu::select([
                                     $detailMenu->getQualifiedKeyName(),
                                     $detailMenu->qualifyColumn('parentid') . ' as menu_id',
                                     $detailMenu->qualifyColumn('menu_adi') . ' as name',
                                     $detailMenu->qualifyColumn('menu_url') . ' as url',
                                 ])
                        ->when(!$fullList, function ($q) use ($detailMenuUser, $detailMenu, $ids) {
                            $q->when(empty($ids), function ($qq) use ($detailMenuUser, $detailMenu) {
                                $qq->join($detailMenuUser->getTable(),
                                          $detailMenu->getQualifiedKeyName(),
                                          '=',
                                          $detailMenuUser->qualifyColumn('menu_id'))
                                   ->where($detailMenuUser->qualifyColumn('userid'), '=', $this->id)
                                   ->where($detailMenuUser->qualifyColumn('durum'), '=', Status::ACTIVE);
                            }, function ($qq) use ($ids, $detailMenu) {
                                $qq->whereIn($detailMenu->getQualifiedKeyName(), $ids);
                            });
                        })
                        ->where($detailMenu->qualifyColumn('durum'), '=', Status::ACTIVE)
                        ->get();
    }

    /**
     * @param array  $ids
     * @param bool   $fullList
     *
     * @return Collection
     */
    public function authorization(array $ids = [], bool $fullList = false): Collection
    {
        $webPortalYetki = WebPortalYetki::getModel();
        $webPortalYetkiIzin = WebPortalYetkiIzin::getModel();

        return WebPortalYetki::select([
                                          $webPortalYetki->getQualifiedKeyName(),
                                          $webPortalYetki->qualifyColumn('menu_id') . ' as menu_id',
                                          $webPortalYetki->qualifyColumn('aciklama') . ' as name',
                                          $webPortalYetki->qualifyColumn('tanim') . ' as authorization',
                                          $webPortalYetki->qualifyColumn('yetki_detay') . ' as menu',
                                      ])
                             ->when(!$fullList, function ($q) use ($webPortalYetkiIzin, $webPortalYetki, $ids) {
                                 $q->when(empty($ids), function ($qq) use ($webPortalYetkiIzin, $webPortalYetki) {
                                     $qq->join($webPortalYetkiIzin->getTable(),
                                               $webPortalYetki->getQualifiedKeyName(),
                                               '=',
                                               $webPortalYetkiIzin->qualifyColumn('yetki_id'))
                                        ->where($webPortalYetkiIzin->qualifyColumn('userid'), '=', $this->id)
                                        ->where($webPortalYetkiIzin->qualifyColumn('usermi'), '=', AuthorizationUserType::AGENT)
                                        ->where($webPortalYetkiIzin->qualifyColumn('durum'), '=', Status::ACTIVE);
                                 }, function ($qq) use ($ids, $webPortalYetki) {
                                     $qq->whereIn($webPortalYetki->getQualifiedKeyName(), $ids);
                                 });
                             })
                             ->where($webPortalYetki->qualifyColumn('durum'), '=', Status::ACTIVE)
                             ->get();
    }

    /**
     * @param array  $ids
     * @param bool   $fullList
     *
     * @return Collection
     */
    public function subscriberBillet(array $ids = [], bool $fullList = false): Collection
    {
        return AboneKutukYetkileri::select([
                                               'id',
                                               'aciklama as name',
                                           ])
                                  ->when(!$fullList, function ($q) use ($ids) {
                                      $q->whereIn('id', $ids);
                                  })
                                  ->active()
                                  ->get();
    }
}
