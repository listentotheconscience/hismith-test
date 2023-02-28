<?php

namespace App\Filters\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface FilterInterface
{
    /**
     * @param Builder|QueryBuilder $builder
     * @return Builder|QueryBuilder
     */
    public function apply(Builder|QueryBuilder $builder): Builder|QueryBuilder;

    /**
     * @param array $filters
     * @return void
     */
    public function setFilters(array $filters): void;
}
