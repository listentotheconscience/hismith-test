<?php

namespace App\Services;

use App\Filters\ArticleFilter;
use App\Http\Requests\Article\ListRequest;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService
{
    public const MAX_ON_PAGE = 10;
    /**
     * @param array $body
     * @return Builder|Model
     */
    public function create(array $body): Model|Builder
    {
        $data = [
            'title' => $body['title'],
            'description' => $body['description'],
            'publication_date' => $body['publication_date'],
            'author' => $body['author']
        ];
        return Article::query()->updateOrCreate($data, $data);
    }

    /**
     * @param ListRequest $request
     * @return LengthAwarePaginator
     */
    public function getList(ListRequest $request): LengthAwarePaginator
    {
        $filter = new ArticleFilter($request);

        return Article::query()
            ->filter($filter)
            ->paginate(self::MAX_ON_PAGE);
    }
}
