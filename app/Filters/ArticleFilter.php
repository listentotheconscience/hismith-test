<?php

namespace App\Filters;

use App\Http\Requests\Article\ListRequest;
use Illuminate\Http\Request;

class ArticleFilter extends QueryFilter
{
    public function __construct(ListRequest $request)
    {
        parent::__construct($request);
    }


    public function sortByPublicationDate(string $value): void
    {
        $this->builder->filterSortByPublicationDate($value);
    }

    public function fields(array $value): void
    {

    }
}
