<?php

namespace App\Factories;

use App\Enums\Brand;
use App\Enums\Call\CallDirection;
use App\Enums\Call\PairStatus;
use App\Enums\EnumInterface;
use App\Enums\Status;
use App\Enums\UserType;
use App\Exceptions\InvalidEnumException;

/**
 * Class EnumFactory
 *
 * @package App\Factories
 *
 * @mixin mixed
 */
class EnumFactory
{
    protected array $enumList = [
        'status'         => Status::class,
        'user_type'      => UserType::class,
        'brand'          => Brand::class,
        'call_direction' => CallDirection::class,
        'pair_status'    => PairStatus::class,
    ];

    /**
     * @param string  $enumType
     *
     * @return EnumInterface
     * @throws InvalidEnumException
     */
    public function create(string $enumType): EnumInterface
    {
        if (!array_key_exists($enumType, $this->enumList)) {
            throw new InvalidEnumException();
        }

        return new $this->enumList[$enumType]();
    }
}
