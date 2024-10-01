<?php

namespace App\Http\Resources;

use App\Enums\Model;
use App\Http\Resources\Call\CallResource;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Log\LogResource;
use App\Http\Resources\QuestionAnswer\QuestionAnswerResource;
use App\Http\Resources\Reason\ReasonResource;
use App\Http\Resources\Staff\StaffGroupResource;
use App\Http\Resources\Url\UrlDefinitionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PaginateFactory
 *
 * @package App\Http\Resources
 *
 * @mixin mixed
 */
class PaginateFactory
{
    public static function apply($data): AnonymousResourceCollection|array
    {
        if ($data->first()) {
            $resourceList = [
                Model::LOG             => LogResource::class,
                Model::QUESTION_ANSWER => QuestionAnswerResource::class,
                Model::EMPLOYEE        => EmployeeResource::class,
                Model::CALL            => CallResource::class,
                Model::STAFF_GROUP     => StaffGroupResource::class,
                Model::URL_DEFINITION  => UrlDefinitionResource::class,
                Model::REASON          => ReasonResource::class,
            ];

            $resourceClass = $resourceList[class_basename($data->first())] ?? null;

            if ($resourceClass && is_subclass_of($resourceClass, JsonResource::class)) {
                return $resourceClass::collection($data->items());
            }
        }

        return [];
    }
}
