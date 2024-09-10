<?php

namespace App\Services;

use App\Exceptions\InvalidEnumException;
use App\Factories\EnumFactory;
use App\Http\Resources\Enum\EnumCollection;
use App\Utils\ArrayUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class EnumService
 *
 * @package App\Service
 */
class EnumService
{
    /**
     * @param Request  $request
     *
     * @return array
     * @throws InvalidEnumException
     */
    public function index(Request $request): array
    {
        $enums = [];
        foreach (ArrayUtil::castArray($request->input('enum_type')) as $enumType) {
            $enums = Arr::add($enums, $enumType, new EnumCollection((new EnumFactory)->create($enumType)::all()));
        }

        return $enums;
    }
}
