<?php

namespace App\Http\Resources\Operator;

use App\Http\Resources\AbstractResource;

/**
 * Class OperatorDefineResource
 *
 * @package App\Http\Resources\Operator
 *
 * @mixin mixed
 */
class OperatorDefineResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'operator_code'         => $this->op_kodu,
            'name'                  => $this->adi,
            'short_name'            => $this->kisa_ad,
            'icon_url'              => $this->icon_url,
            'sms_cdr_report'        => $this->smscdrbildir,
            'subscriber_cdr_report' => $this->abonecdrbildir,
            'voice_cdr_report'      => $this->sescdrbildir,
            'web_user_id'           => $this->webuser_id,
            'direct_code'           => $this->yonlendirme_kodu,
            'is_abroad'             => $this->yurtdisimi,
            'btk_code'              => $this->btk_kodu,
        ];
    }
}
