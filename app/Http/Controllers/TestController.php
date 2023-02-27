<?php

namespace App\Http\Controllers;

use App\Filters\ArticleFilter;
use App\Http\Requests\Article\ListRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use App\Services\MediaService;
use App\Services\RssService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @param ListRequest $request
     * @param ArticleService $articleService
     * @return HttpResponse|Application|ResponseFactory
     */
    public function getList(ListRequest $request, ArticleService $articleService): HttpResponse|Application|ResponseFactory
    {
        return response(
            ArticleResource::collection($articleService->getList($request)),
            Response::HTTP_OK
        );
    }
}
