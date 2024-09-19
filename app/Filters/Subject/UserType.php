<?php

namespace App\Filters\Subject;

use App\Exceptions\InvalidParameterException;
use App\Utils\ArrayUtil;

class UserType
{
    /**
     * @throws InvalidParameterException
     */
    public function apply($query, $value): void
    {
        $userTypeIds = ArrayUtil::numericalCommaToArray($value);

        $query->where(function ($q) use ($userTypeIds) {
            foreach ($userTypeIds as $userTypeId) {
                $q->orWhere('kullanici_tipi', 'LIKE', '%,' . $userTypeId . ',%')
                  ->orWhere('kullanici_tipi', 'LIKE', $userTypeId . ',%')
                  ->orWhere('kullanici_tipi', 'LIKE', '%,' . $userTypeId)
                  ->orWhere('kullanici_tipi', $userTypeId)
                  ->whereNotNull('kullanici_tipi');
            }
        });
    }
}
