<?php

namespace App\Services;

use App\Enums\Authorization\AuthorizationType;
use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SubscriberBillet;
use App\Enums\DefaultConstant;
use App\Models\Authorization\AboneKutukYetkileri;
use App\Models\Staff\PersonelGrupEslestir;
use App\Models\Staff\PersonelGrupYetkiEslestir;
use App\Services\Authorization\AuthorizationService;
use Illuminate\Support\Facades\Auth;

/**
 * Class DataMaskingService
 *
 * @package App\Service
 */
class DataMaskingService
{
    protected array $fieldsMapping = [
        SubscriberBillet::SHOW_IDENTITY_NO        => [
            'tckimlik',
            'idnumber',
            'identity'
        ],
        SubscriberBillet::SHOW_PHONE_NO           => [
            'tel',
            'kaynaksmscep',
            'sabittel',
            'phone',
            'cep',
            'ceptel',
            'hometel',
            'evtel',
            'numara',
            'telefon',
            'telefon_no'
        ],
        SubscriberBillet::SHOW_BIRTHDAY_DATE      => [
            'dog_yil',
            'birthdate',
            'dogumtarih'
        ],
        SubscriberBillet::SHOW_IDENTITY_SERIAL_NO => [
            'kimlikseri'
        ],
        SubscriberBillet::SHOW_MAIL               => [
            'email',
            'mail'
        ]
    ];

    /**
     * @param array  $data
     *
     * @return array
     */
    public function halfHide(array $data): array
    {
        $fieldsToHide = self::fieldsToHide();
        if (empty($fieldsToHide)) {
            return $data;
        }

        foreach ($fieldsToHide as $fields) {
            if (isset($this->fieldsMapping[$fields['id']])) {
                $keywords = $this->fieldsMapping[$fields['id']];
                foreach ($data as $key => $value) {
                    if (!is_null($value) && $this->containsKeyword($key, $keywords)) {
                        $data[$key] = $this->applyMask($fields['id'], $value);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param $fieldId
     * @param $value
     * @return string
     */
    private function applyMask($fieldId, $value): string
    {
        return match ($fieldId) {
            SubscriberBillet::SHOW_IDENTITY_NO,
            SubscriberBillet::SHOW_PHONE_NO,
            SubscriberBillet::SHOW_IDENTITY_SERIAL_NO => $this->maskText($value),
            SubscriberBillet::SHOW_BIRTHDAY_DATE => $this->maskDate(),
            SubscriberBillet::SHOW_MAIL => $this->maskAverage($value),
            default => $value
        };
    }

    /**
     * @param $key
     * @param $keywords
     *
     * @return bool
     */
    private function containsKeyword($key, $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($key, $keyword)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $value
     *
     * @return string
     */
    private function maskAverage($value): string
    {
        return substr($value, 0, 3) . str_pad('', strlen($value) - 6, DefaultConstant::HIDE_SIGN) . substr($value, -7);
    }

    /**
     * @param $value
     *
     * @return string
     */
    private function maskText($value): string
    {
        return substr($value, 0, 2) . str_pad('', strlen($value) - 3, DefaultConstant::HIDE_SIGN);
    }

    /**
     * @return string
     */
    private function maskDate(): string
    {
        return DefaultConstant::HIDE_DATE_FORMAT;
    }

    /**
     * @return array
     */
    public static function fieldsToHide(): array
    {
        $authorizationIds = AuthorizationService::parseAuthorizationString(Auth::user()?->yetki_string);
        if (empty($authorizationIds)) {
            return [];
        }

        $staffGroupAuthorizationMatchIds = PersonelGrupYetkiEslestir::active()
                                                                    ->where('tip', AuthorizationType::SUBSCRIBER_BILLET)
                                                                    ->whereIn('personel_grup_id',
                                                                              PersonelGrupEslestir::select('personel_grup_id')
                                                                                                  ->active()
                                                                                                  ->where('personel_id', Auth::id())
                                                                    )
                                                                    ->get()
                                                                    ->pluck('yetki_id')
                                                                    ->toArray();

        return AboneKutukYetkileri::active()
                                  ->when(!empty(array_intersect($staffGroupAuthorizationMatchIds,
                                                                $authorizationIds[AuthorizationTypeName::SUBSCRIBER_BILLET])),
                                      function ($q) use ($staffGroupAuthorizationMatchIds) {
                                          $q->whereNotIn('id', $staffGroupAuthorizationMatchIds);
                                      })
                                  ->get()
                                  ->toArray();
    }
}
