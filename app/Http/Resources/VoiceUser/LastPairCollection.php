<?php

namespace App\Http\Resources\VoiceUser;

use App\Http\Resources\AbstractCollection;

/**
 * Class LastPairCollection
 *
 * @package App\Http\Resources\VoiceUser
 *
 * @mixin mixed
 */
class LastPairCollection extends AbstractCollection
{
    public $collects = LastPairResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
