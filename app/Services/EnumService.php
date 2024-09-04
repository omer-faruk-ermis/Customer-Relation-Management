<?php

namespace App\Services;

use App\Exceptions\InvalidEnumException;
use App\Factories\EnumFactory;
use Illuminate\Http\Request;

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
     * @return object
     * @throws InvalidEnumException
     */
    public function index(Request $request): object
    {
        return (new EnumFactory)->create($request->input('enum_type'))::all();
    }
}
