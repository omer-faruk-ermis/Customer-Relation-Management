<?php

namespace App\Services\Authorization;

use App\Enums\Authorization\AuthorizationType;
use App\Enums\Authorization\AuthorizationTypeName;
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
    private array $authorizations;
    private int $id;

    /**
     * @param int  $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->authorizations = [
            AuthorizationTypeName::SMS_MANAGEMENT    => self::mergeAuthorization($this->smsManagement(), AuthorizationType::SMS_MANAGEMENT),
            AuthorizationTypeName::BLUE_SCREEN       => self::mergeAuthorization($this->blueScreen(), AuthorizationType::BLUE_SCREEN),
            AuthorizationTypeName::AUTHORIZATION     => self::mergeAuthorization($this->authorization(), AuthorizationType::AUTHORIZATION),
            AuthorizationTypeName::SUBSCRIBER_BILLET => self::mergeAuthorization($this->subscriberBillet(), AuthorizationType::SUBSCRIBER_BILLET),
        ];
    }

    /**
     * @return array
     */
    public function getAuthorizations(): array
    {
        return $this->authorizations;
    }

    /**
     * @param array|Collection  $authorizations
     * @param int               $type
     *
     * @return array
     */
    protected function mergeAuthorization(array|Collection $authorizations, int $type): array
    {
        $employeeGroups = self::authorizationGroup($type);

        if (AuthorizationType::SMS_MANAGEMENT == $type) {
            $employeeGroup = self::authorizationMatch(self::smsManagement($employeeGroups), $authorizations);

            return $employeeGroup->groupBy('menu')
                                 ->toArray();
        } else if (AuthorizationType::BLUE_SCREEN == $type) {
            $employeeGroup = self::authorizationMatch(self::blueScreen($employeeGroups), $authorizations);

            return $employeeGroup->groupBy(fn($q) => $q->menu_id)
                                 ->mapWithKeys(fn($group) => [
                                     $group->first()->name => $group->first()->menu_id != NumericalConstant::ZERO ? $group : []
                                 ])
                                 ->toArray();
        } else if (AuthorizationType::AUTHORIZATION == $type) {
            $employeeGroup = self::authorizationMatch(self::authorization($employeeGroups), $authorizations);

            return $employeeGroup->groupBy('authorization')
                                 ->toArray();
        } else if (AuthorizationType::SUBSCRIBER_BILLET == $type) {
            $employeeGroup = self::authorizationMatch(self::subscriberBillet($employeeGroups), $authorizations);

            return ['Abone Kütük Yetkileri' => $employeeGroup->toArray()];
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
     * @param int  $type
     *
     * @return array
     */
    protected function authorizationGroup(int $type): array
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
                               ->where($personelGruplari->qualifyColumn('durum'), '=', Status::ACTIVE)
                               ->where($personelGruplariEslestir->qualifyColumn('personel_id'), '=', $this->id)
                               ->where($personelGruplariEslestir->qualifyColumn('durum'), '=', Status::ACTIVE)
                               ->where($personelGrupYetkiEslestir->qualifyColumn('durum'), '=', Status::ACTIVE)
                               ->where($personelGrupYetkiEslestir->qualifyColumn('tip'), '=', $type)
                               ->get()
                               ->pluck('authorization_id')
                               ->toArray();
    }

    /**
     * @param array  $ids
     *
     * @return Collection
     */
    protected function smsManagement(array $ids = []): Collection
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
                       ->when(empty($ids), function ($q) use ($smsKimlikYetki, $urlTanim) {
                           $q->join($smsKimlikYetki->getTable(),
                                    $urlTanim->getQualifiedKeyName(),
                                    '=',
                                    $smsKimlikYetki->qualifyColumn('url_id'))
                             ->where($smsKimlikYetki->qualifyColumn('sms_kimlik'), '=', $this->id)
                             ->where($smsKimlikYetki->qualifyColumn('durum'), '=', Status::ACTIVE);
                       })
                       ->when(!empty($ids), function ($q) use ($ids, $urlTanim) {
                           $q->whereIn($urlTanim->getQualifiedKeyName(), $ids);
                       })
                       ->where($urlTanim->qualifyColumn('durum'), '=', Status::ACTIVE)
                       ->where($menuTanim->qualifyColumn('durum'), '=', Status::ACTIVE)
                       ->orderBy($menuTanim->qualifyColumn('sira'))
                       ->get();
    }

    /**
     * @param array  $ids
     *
     * @return Collection
     */
    protected function blueScreen(array $ids = []): Collection
    {
        $detailMenu = DetayMenu::getModel();
        $detailMenuUser = DetayMenuUser::getModel();

        return DetayMenu::select([
                                     $detailMenu->getQualifiedKeyName(),
                                     $detailMenu->qualifyColumn('parentid') . ' as menu_id',
                                     $detailMenu->qualifyColumn('menu_adi') . ' as name',
                                     $detailMenu->qualifyColumn('menu_url') . ' as url',
                                 ])
                        ->when(empty($ids), function ($q) use ($detailMenuUser, $detailMenu) {
                            $q->join($detailMenuUser->getTable(),
                                     $detailMenu->getQualifiedKeyName(),
                                     '=',
                                     $detailMenuUser->qualifyColumn('menu_id'))
                              ->where($detailMenuUser->qualifyColumn('userid'), '=', $this->id)
                              ->where($detailMenuUser->qualifyColumn('durum'), '=', Status::ACTIVE);
                        })
                        ->when(!empty($ids), function ($q) use ($ids, $detailMenu) {
                            $q->whereIn($detailMenu->getQualifiedKeyName(), $ids);
                        })
                        ->where($detailMenu->qualifyColumn('durum'), '=', Status::ACTIVE)
                        ->get();
    }

    /**
     * @param array  $ids
     *
     * @return Collection
     */
    protected function authorization(array $ids = []): Collection
    {
        $webPortalYetki = WebPortalYetki::getModel();
        $webPortalYetkiIzin = WebPortalYetkiIzin::getModel();

        return WebPortalYetki::select([
                                          $webPortalYetki->getQualifiedKeyName(),
                                          $webPortalYetki->qualifyColumn('menu_id') . ' as menu_id',
                                          $webPortalYetki->qualifyColumn('aciklama') . ' as name',
                                          $webPortalYetki->qualifyColumn('tanim') . ' as authorization',
                                      ])
                             ->when(empty($ids), function ($q) use ($webPortalYetkiIzin, $webPortalYetki) {
                                 $q->join($webPortalYetkiIzin->getTable(),
                                          $webPortalYetki->getQualifiedKeyName(),
                                          '=',
                                          $webPortalYetkiIzin->qualifyColumn('yetki_id'))
                                   ->where($webPortalYetkiIzin->qualifyColumn('userid'), '=', $this->id)
                                   ->where($webPortalYetkiIzin->qualifyColumn('usermi'), '=', AuthorizationUserType::AGENT)
                                   ->where($webPortalYetkiIzin->qualifyColumn('durum'), '=', Status::ACTIVE);
                             })
                             ->when(!empty($ids), function ($q) use ($ids, $webPortalYetki) {
                                 $q->whereIn($webPortalYetki->getQualifiedKeyName(), $ids);
                             })
                             ->where($webPortalYetki->qualifyColumn('durum'), '=', Status::ACTIVE)
                             ->get();
    }

    /**
     * @param array  $ids
     *
     * @return Collection
     */
    protected function subscriberBillet(array $ids = []): Collection
    {
        return AboneKutukYetkileri::select([
                                               'id',
                                               'aciklama as name',
                                           ])
                                  ->whereIn('id', $ids)
                                  ->where('durum', '=', Status::ACTIVE)
                                  ->get();
    }
}
