<?php

namespace App\Builder;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Models\Menu\MenuTanim;
use App\Models\Module\Module;
use App\Models\SmsKimlik\SmsKimlik;
use App\Models\Url\UrlTanim;
use App\Services\Authorization\AuthorizationService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SmsKimlikBuilder
{
    /**
     * @param $smsKimlik ,
     *
     *
     * @return SmsKimlik
     */
    public static function handle($smsKimlik): SmsKimlik
    {
        $authorization = (new AuthorizationService($smsKimlik['id']));
        $authorizationWithPluck = (new AuthorizationService($smsKimlik['id'], true));

        $pages = self::getPages($authorizationWithPluck);
        $menus = self::getMenus($pages);
        $modules = self::getModules($menus);
        $serviceAuthorizations = self::getServiceAuthorizations();

        Arr::forget($smsKimlik, 'authorizations');
        Arr::forget($smsKimlik, 'service_authorizations');
        Arr::forget($smsKimlik, 'yetki_string');
        Arr::forget($smsKimlik, 'module');

        $smsKimlik = Arr::add($smsKimlik, 'dbname', getenv('DSN'));
        $smsKimlik = Arr::add($smsKimlik, 'sms_kimlik', $smsKimlik['id']);
        $smsKimlik = Arr::add($smsKimlik, 'personelkimlik', $smsKimlik['id']);
        $smsKimlik = Arr::add($smsKimlik, 'sipid', $smsKimlik['sip'][0]['sip_id']);
        $smsKimlik = Arr::add($smsKimlik, 'user_authenticated', 540);

        $smsKimlik = Arr::add($smsKimlik, 'authorizations', $authorization->getAuthorizations());
        // TODO: authorizations kaldırılacak, process_authorizations, module altına geçirilecek.

        $smsKimlik = Arr::add($smsKimlik, 'service_authorizations', $serviceAuthorizations);
        $smsKimlik = Arr::add($smsKimlik, 'yetki_string', $authorizationWithPluck->getAuthorizationString());
        $smsKimlik = Arr::add($smsKimlik, 'module', $modules);

        return $smsKimlik;
    }

    /**
     * @param AuthorizationService  $authorizationWithPluck
     *
     * @return Collection
     */
    private static function getPages(AuthorizationService $authorizationWithPluck): Collection
    {
        $pageIds = $authorizationWithPluck->getAuthorizationsGrouped()[AuthorizationTypeName::SMS_MANAGEMENT]->toArray();
        return UrlTanim::whereIn('id', $pageIds)->get();
    }

    /**
     * @param $pages
     *
     * @return mixed
     */
    private static function getMenus($pages): mixed
    {
        return MenuTanim::whereIn('id', $pages->pluck('ust_id')->toArray())
                        ->get()
                        ->map(function ($menu) use ($pages) {
                            $menu->page_data = $pages->filter(fn($page) => $menu->id == $page->ust_id)->values()->all();
                            return $menu;
                        });
    }

    /**
     * @param $menus
     *
     * @return mixed
     */
    private static function getModules($menus): mixed
    {
        return Module::whereIn('id', $menus->pluck('module_id')->toArray())
                     ->get()
                     ->map(function ($module) use ($menus) {
                         $module->menu_data = $menus->filter(fn($menu) => $module->id == $menu->module_id)->values()->all();
                         return $module;
                     });
    }

    /**
     * @return Collection
     */
    private static function getServiceAuthorizations(): Collection
    {
        return DB::table('kaynaksms_diger.dbo.page_services as ps')
                 ->join('kaynaksms_diger.dbo.services as s', 'ps.service_id', '=', 's.id')
                 ->get();
    }
}
