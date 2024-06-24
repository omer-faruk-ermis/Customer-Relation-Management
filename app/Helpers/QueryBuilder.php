<?php

namespace App\Helpers;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class QueryBuilder
{
    /**
     * @param string  $column
     * @param string  $collation
     *
     * @return Expression
     */
    public static function collate(string $column, string $collation = 'SQL_Latin1_General_CP1254_CI_AS'): Expression
    {
        return DB::raw("$column COLLATE $collation");
    }

    /**
     * Convert the query results into model instances.
     *
     * This function takes a query result and a model class,
     * and maps the query results to instances of the specified model class.
     * The original query collection is replaced with these model instances.
     *
     * @param LengthAwarePaginator  $query
     * @param string                $modelClass
     *
     * @return LengthAwarePaginator
     */
    public static function convertToModels(LengthAwarePaginator $query, string $modelClass): LengthAwarePaginator
    {
        $items = $query->getCollection()->map(function ($item) use ($modelClass) {
            $model = new $modelClass();
            foreach ($item as $key => $value) {
                $model->{$key} = $value;
            }
            return $model;
        });

        $query->setCollection($items);

        return $query;
    }

    /**
     * This function takes a sub query and transforms it into a raw SQL sub query,
     * then merges the bindings of the sub query into the main query.
     *
     * @param $subQuery
     *
     * @return Builder
     */
    public static function createSubQuery($subQuery): Builder
    {
        return DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
                 ->mergeBindings($subQuery->getQuery());
    }

    /**
     *
     * @param $models
     * @param $relations
     *
     * @return mixed
     */
    public static function reloadRelations($models, $relations): mixed
    {
        foreach ($models as $model) {
            $model->load($relations);
        }

        return $models;
    }
}
