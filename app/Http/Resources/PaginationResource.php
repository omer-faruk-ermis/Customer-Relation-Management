<?php

namespace App\Http\Resources;

/**
 * Class PaginationResource
 *
 * @package App\Http\Resources
 *
 * @mixin mixed
 */
class PaginationResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data'         => (new PaginateData)->apply($this),
            'current_page' => $this->resource->currentPage(),
            'last_page'    => $this->resource->lastPage(),
            'per_page'     => $this->resource->perPage(),
            'to'           => $this->resource->lastItem(),
            'total'        => $this->resource->total(),
        ];
    }
}
