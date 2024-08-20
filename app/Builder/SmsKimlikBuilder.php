<?php

namespace App\Builder;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Exceptions\ForbiddenException;
use App\Models\SmsKimlik\SmsKimlik;
use App\Services\Authorization\AuthorizationService;
use App\Services\Menu\MenuDefinitionService;
use App\Services\Module\ModuleService;
use App\Services\Url\UrlDefinitionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SmsKimlikBuilder
{
    /**
     * @param $sms_kimlik
     *
     * @return SmsKimlik
     * @throws ForbiddenException
     */
    public static function handle($sms_kimlik): SmsKimlik
    {
        $authorization = (new AuthorizationService($sms_kimlik['id']));
        $authorizationWithPluck = (new AuthorizationService($sms_kimlik['id'], true));

        $pages = (new UrlDefinitionService(new Request()))
            ->page(new Request(), $authorizationWithPluck->getAuthorizationsGrouped()[AuthorizationTypeName::SMS_MANAGEMENT]
                ->toArray());

        $menus = (new MenuDefinitionService(new Request()))
            ->menu(new Request(), $pages);

        $modules = (new ModuleService(new Request()))
            ->index(new Request(), $menus);

        $sms_kimlik = Arr::add($sms_kimlik, 'dbname', getenv('DSN'));
        $sms_kimlik = Arr::add($sms_kimlik, 'sms_kimlik', $sms_kimlik['id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'personelkimlik', $sms_kimlik['id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'sipid', $sms_kimlik['sip'][0]['sip_id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'user_authenticated', 540);
        $sms_kimlik = Arr::add($sms_kimlik, 'authorizations', $authorization->getAuthorizations());
        $sms_kimlik = Arr::add($sms_kimlik, 'yetki_string', $authorizationWithPluck->getAuthorizationString());
        $sms_kimlik = Arr::add($sms_kimlik, 'module', $modules);

        return $sms_kimlik;
    }
}
