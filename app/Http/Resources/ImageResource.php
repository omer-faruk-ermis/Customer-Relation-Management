<?php

namespace App\Http\Resources;

/**
 * Class ImageResource
 *
 * @package App\Http\Resources
 *
 * @mixin mixed
 */
class ImageResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'image_path'    => $this->image_path,
            'image_content' => $this->image_content,
            'content_type'  => $this->content_type,
        ];
    }
}
