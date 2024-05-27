<?php

namespace App\Services\Strategies;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\Status;
use App\Exceptions\ForbiddenException;
use App\Models\Authorization\SmsKimlikYetki;
use App\Models\Url\UrlTanim;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SmsManagementStrategy implements PermissionStrategy
{
    /**
     * @param Request  $request
     * @param array    $authorizationIds
     * @param array    $authorizations
     *
     * @return bool
     * @throws ForbiddenException
     */
    public function check(Request $request, array $authorizationIds, array $authorizations): bool
    {
        if (Arr::get($authorizations, AuthorizationTypeName::SMS_MANAGEMENT) && !empty($authorizationIds)) {
            if (SmsManagement::hasValue(Arr::get($authorizations, AuthorizationTypeName::SMS_MANAGEMENT))
                && !empty(array_intersect($authorizations[AuthorizationTypeName::SMS_MANAGEMENT], $authorizationIds[AuthorizationTypeName::SMS_MANAGEMENT]))) {

                $url = UrlTanim::where('url', $request->input('url'))
                               ->whereIn('id', $authorizations[AuthorizationTypeName::SMS_MANAGEMENT])
                               ->where('durum', Status::ACTIVE)
                               ->first();

                if ($url && SmsKimlikYetki::where('url_id', $url->id)
                                          ->where('sms_kimlik', Auth::id())
                                          ->where('durum', Status::ACTIVE)
                                          ->exists()) {
                    return true;
                }
            }

            throw new ForbiddenException();
        }

        return true;
    }
}
