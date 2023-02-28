<?php

namespace App\Filters;

use App\Http\Requests\Article\ListRequest;
use Illuminate\Http\Request;

/**
 * Article filter class
 *
 * @package App\Filters
 */
class ArticleFilter extends QueryFilter
{
    /**
     * @param ListRequest $request
     */
    public function __construct(ListRequest $request)
    {
        parent::__construct($request);
    }

    /**
     * @param string $value
     * @return void
     */
    public function sortByPublicationDate(string $value): void
    {
        $this->builder->filterSortByPublicationDate($value);
    }
}
