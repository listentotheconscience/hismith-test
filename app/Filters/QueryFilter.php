<?php

namespace App\Filters;

use App\Filters\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;

abstract class QueryFilter implements FilterInterface
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Builder|QueryBuilder
     */
    protected Builder|QueryBuilder $builder;

    /**
     * @var array
     */
    protected array $filters;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder|QueryBuilder $builder): Builder|QueryBuilder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value) {
            $filter = str_replace('_', '', $filter);

            if (method_exists($this, $filter) && !is_null($value)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    public function addFilters(array $filters): void
    {
        $this->filters = array_merge($this->filters(), $filters);
    }

    public function filters(): array
    {
        return $this->filters ?? $this->request->all();
    }

    public function existsFilter(string $filter): bool
    {
        return array_key_exists($filter, $this->filters());
    }

    public function getFilterValue(string $filter)
    {
        return $this->filters()[$filter];
    }
}
