<?php

namespace App\Http\Resources;

use App\Enums\Model;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Log\LogResource;
use App\Http\Resources\QuestionAnswer\QuestionAnswerResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PaginateData
 *
 * @package App\Http\Resources
 *
 * @mixin mixed
 */
class PaginateData
{
    public static function apply($data): AnonymousResourceCollection|array
    {
        if ($data->first()) {
            $resourceMapping = [
                Model::LOG             => LogResource::class,
                Model::QUESTION_ANSWER => QuestionAnswerResource::class,
                Model::EMPLOYEE        => EmployeeResource::class,
            ];

            $resourceClass = $resourceMapping[class_basename($data->first())] ?? null;

            if ($resourceClass && is_subclass_of($resourceClass, JsonResource::class)) {
                return $resourceClass::collection($data->resource->items());
            }
        }

        return [];
    }
}
