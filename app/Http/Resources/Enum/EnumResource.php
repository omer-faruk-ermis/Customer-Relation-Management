<?php

namespace App\Http\Resources\Enum;

use App\Http\Resources\AbstractResource;

/**
 * Class EnumResource
 *
 * @package App\Http\Resources\Enum
 *
 * @mixin mixed
 */
class EnumResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'          => !is_array($this->id) ? $this->id : null,
            'key'         => $this->key,
            'label'       => $this->label,
            'description' => $this->description,
            'value'       => $this->value,
        ];
    }
}
