<?php

namespace App\Filters;

abstract class AbstractFilter
{
    protected $filters;

    public function __construct()
    {
        $this->filters = $this->defineFilters();
    }

    public static function apply($query, $filter)
    {
        foreach ($filter as $field => $value) {
            (new static())->applyFilter($query, $field, $value);
        }

        return $query;
    }

    protected function applyFilter($query, $field, $value): void
    {
        if(array_key_exists($field, $this->filters)) {
            (new $this->filters[$field])->apply($query, $value);
        } else {
            return;
        }
    }

    abstract protected function defineFilters();
}
