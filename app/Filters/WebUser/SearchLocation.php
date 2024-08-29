<?php

namespace App\Filters\WebUser;

use App\Enums\DefaultConstant;

class SearchLocation
{
    const USER_ID_LENGTH = 9;
    const START_ZERO = 0;
    const START_DOUBLE_ZERO = 00;
    const START_ONE = 1;
    const START_FIVE = 5;
    const START_ZERO_FIVE = 05;

    public function apply($query, $value): void
    {
        $length = strlen($value);
        $firstChar = substr($value, 0, 1);
        $twoChar = substr($value, 0, 2);
        $threeChar = substr($value, 0, 3);

        $query
            ->when(is_numeric($value),
                function ($query) use ($length, $value, $firstChar, $threeChar, $twoChar) {
                    $query
                        // USER_ID
                        ->when(self::USER_ID_LENGTH > $length, function ($q) use ($value) {
                            $q->whereLike('id', $value);
                        })
                        // SUBSCRIBER PHONE/NO
                        ->when((DefaultConstant::LOCAL_PHONE_LENGTH >= $length) && ($length > 6),
                            function ($q) use ($value, $firstChar, $threeChar, $length) {
                                $q->when((self::START_ZERO != $firstChar && self::START_ONE != $firstChar)
                                         || DefaultConstant::NETGSM_PHONE_PREFIX == $threeChar,
                                    function ($qq) use ($length, $value) {
                                        $qq->when(DefaultConstant::LOCAL_PHONE_LENGTH == $length,
                                            function ($qqq) use ($value) {
                                                $qqq->where('aboneNoThk.telno', '=', $value);
                                            },
                                            function ($qqq) use ($value) {
                                                $qqq->whereBetween('aboneNoAndThk.telno', [
                                                    substr($value . "0000000000", self::START_ZERO, DefaultConstant::LOCAL_PHONE_LENGTH),
                                                    substr($value . "9999999999", self::START_ZERO, DefaultConstant::LOCAL_PHONE_LENGTH)
                                                ]);
                                            });
                                    });
                            })
                        // MOBILE PHONE
                        ->when(DefaultConstant::INTERNATIONAL_PHONE_LENGTH > $value
                               || self::START_FIVE == $firstChar
                               || self::START_ZERO_FIVE == $twoChar
                               || self::START_DOUBLE_ZERO == $twoChar,
                            function ($q) use ($value) {
                                $q->whereLike('ceptel', $value);
                            })
                        // IDENTITY_NO
                        ->when(DefaultConstant::IDENTITY_NO_LENGTH == $value
                               && self::START_ZERO != $firstChar,
                            function ($q) use ($value) {
                                $q->whereLike('tckimlik', $value);
                            })
                        // TAX IDENTIFICATION NUMBER
                        ->when(DefaultConstant::TAX_IDENTIFICATION_NO_LENGTH == $value,
                            function ($q) use ($value) {
                                $q->whereLike('verginumarasi', $value);
                            });
                },
                function ($query) use ($value) {
                    $query
                        ->when(preg_match(DefaultConstant::EMAIL_PATTERN, $value),
                            // EMAIL
                            function ($q) use ($value) {
                                $q->when(filter_var($value, FILTER_VALIDATE_EMAIL), function ($qq) use ($value) {
                                    $qq->where('email', '=', $value);
                                }, function ($qq) use ($value) {
                                    $qq->whereLike('email', $value);
                                });
                            },
                            // GENERAL STRING MATCH
                            function ($q) use ($value) {
                                $q
                                    // USERNAME
                                    ->orWhere('name', 'LIKE', '%' . $value . '%')
                                    // NAME AND SURNAME
                                    ->orWhereRaw("CONCAT(ad, ' ', soyad) LIKE ?", ['%' . $value . '%'])
                                    // CORPORATION NAME
                                    ->orWhere('kurumadi', 'LIKE', '%' . $value . '%');
                            });
                });
    }
}
