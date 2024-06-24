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
            'data'         => PaginateFactory::apply($this),
            'current_page' => $this->currentPage(),
            'last_page'    => $this->lastPage(),
            'per_page'     => $this->perPage(),
            'to'           => $this->lastItem(),
            'total'        => $this->total(),
        ];
    }
}
