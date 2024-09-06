<?php

namespace App\Config;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\SqlServerGrammar as QueryGrammar;
use Illuminate\Support\Arr;

class SqlServerGrammar extends QueryGrammar
{
    /**
     * Compile a select query into SQL.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return string
     */
    public function compileSelect(Builder $query)
    {
        if (! $query->offset) {
            return parent::compileSelect($query);
        }

        // If an offset is present on the query, we will need to wrap the query in
        // a big "ANSI" offset syntax block. This is very nasty compared to the
        // other database systems but is necessary for implementing features.
        if (is_null($query->columns)) {
            $query->columns = ['*'];
        }

        return $this->compileAnsiOffset(
            $query, $this->compileComponents($query)
        );
    }
    /**
     * Compile the "limit" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  int  $limit
     * @return string
     */
    protected function compileLimit(Builder $query, $limit)
    {
        return '';
    }
    /**
     * Compile the "offset" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  int  $offset
     * @return string
     */
    protected function compileOffset(Builder $query, $offset)
    {
        return '';
    }

    /**
     * Create a full ANSI offset clause for the query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  array  $components
     * @return string
     */
    protected function compileAnsiOffset(Builder $query, $components)
    {
        // An ORDER BY clause is required to make this offset query work, so if one does
        // not exist we'll just create a dummy clause to trick the database and so it
        // does not complain about the queries for not having an "order by" clause.
        if (empty($components['orders'])) {
            $components['orders'] = 'order by (select 0)';
        }

        // We need to add the row number to the query so we can compare it to the offset
        // and limit values given for the statements. So we will add an expression to
        // the "select" that will give back the row numbers on each of the records.
        $components['columns'] .= $this->compileOver($components['orders']);

        unset($components['orders']);

        if ($this->queryOrderContainsSubquery($query)) {
            $query->bindings = $this->sortBindingsForSubqueryOrderBy($query);
        }

        // Next we need to calculate the constraints that should be placed on the query
        // to get the right offset and limit from our query but if there is no limit
        // set we will just handle the offset only since that is all that matters.
        $sql = $this->concatenate($components);

        return $this->compileTableExpression($sql, $query);
    }

    /**
     * Determine if the query's order by clauses contain a subquery.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return bool
     */
    protected function queryOrderContainsSubquery($query)
    {
        if (! is_array($query->orders)) {
            return false;
        }

        return Arr::first($query->orders, function ($value) {
                return $this->isExpression($value['column'] ?? null);
            }, false) !== false;
    }

    /**
     * Move the order bindings to be after the "select" statement to account for an order by subquery.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return array
     */
    protected function sortBindingsForSubqueryOrderBy($query)
    {
        return Arr::sort($query->bindings, function ($bindings, $key) {
            return array_search($key, ['select', 'order', 'from', 'join', 'where', 'groupBy', 'having', 'union', 'unionOrder']);
        });
    }

    /**
     * Compile a common table expression for a query.
     *
     * @param  string  $sql
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return string
     */
    protected function compileTableExpression($sql, $query)
    {
        $constraint = $this->compileRowConstraint($query);

        return "select * from ({$sql}) as temp_table where row_num {$constraint} order by row_num";
    }

    /**
     * Compile the limit / offset row constraint for a query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return string
     */
    protected function compileRowConstraint($query)
    {
        $start = (int) $query->offset + 1;

        if ($query->limit > 0) {
            $finish = (int) $query->offset + (int) $query->limit;

            return "between {$start} and {$finish}";
        }

        return ">= {$start}";
    }

    /**
     * Compile the over statement for a table expression.
     *
     * @param  string  $orderings
     * @return string
     */
    protected function compileOver($orderings)
    {
        return ", row_number() over ({$orderings}) as row_num";
    }
}
