<?php

namespace App\Http\Resources\Operator;

use App\Http\Resources\AbstractCollection;

/**
 * Class OperatorDefineCollection
 *
 * @package App\Http\Resources\Operator
 *
 * @mixin mixed
 */
class OperatorDefineCollection extends AbstractCollection
{
    public $collects = OperatorDefineResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
