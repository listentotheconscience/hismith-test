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
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * @param ListRequest $request
     * @param ArticleService $articleService
     * @return HttpResponse|Application|ResponseFactory
     * @OA\Get(
     *      path="/api/articles",
     *      tags={"Articles"},
     *      summary="Get article list",
     *      @OA\Parameter(
     *          parameter="sortByPublicationDate",
     *          name="sortByPublicationDate",
     *          description="Accept only 'asc' or 'desc'",
     *          required=false,
     *          in="query",
     *          example="desc"
     *      ),
     *      @OA\Parameter(
     *          parameter="fields",
     *          name="fields",
     *          description="list of fileds to display",
     *          required=false,
     *          in="query"
     *      ),
     *     @OA\Parameter(
     *          parameter="page",
     *          name="page",
     *          required=false,
     *          in="query",
     *          example="1"
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ArticleResource")
     *          )
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Validation error"
     *      )
     * )
     */
    public function getList(ListRequest $request, ArticleService $articleService): HttpResponse|Application|ResponseFactory
    {
        return response(
            ArticleResource::collection($articleService->getList($request)),
            Response::HTTP_OK
        );
    }
}
