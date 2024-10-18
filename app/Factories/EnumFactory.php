<?php

namespace App\Factories;

use App\Enums\AgreementType;
use App\Enums\Authorization\AuthorizationType;
use App\Enums\Brand;
use App\Enums\Call\CallDirection;
use App\Enums\Call\PairStatus;
use App\Enums\CustomerPriority;
use App\Enums\MeetingTypeSpecies;
use App\Enums\ReasonType;
use App\Enums\SearchLocation;
use App\Enums\Status;
use App\Enums\UserModel;
use App\Enums\UserType;
use App\Enums\UserUseType;
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
        'status'               => Status::class,
        'user_type'            => UserType::class,
        'brand'                => Brand::class,
        'call_direction'       => CallDirection::class,
        'pair_status'          => PairStatus::class,
        'meeting_type_species' => MeetingTypeSpecies::class,
        'reason_type'          => ReasonType::class,
        'authorization_type'   => AuthorizationType::class,
        'customer_priority'    => CustomerPriority::class,
        'user_model'           => UserModel::class,
        'agreement_type'       => AgreementType::class,
        'user_use_type'        => UserUseType::class,
        'search_location'      => SearchLocation::class,
    ];

    /**
     * @param string  $enumType
     *
     * @return mixed
     * @throws InvalidEnumException
     */
    public function create(string $enumType): mixed
    {
        if (!array_key_exists($enumType, $this->enumList)) {
            throw new InvalidEnumException();
        }

        return new $this->enumList[$enumType]();
    }
}
