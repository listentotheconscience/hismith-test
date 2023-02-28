<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * Article resource class
 * @OA\Schema(
 *     title="Article list",
 *        @OA\Property(
 *            property="id",
 *            type="integer",
 *            example="1"
 *        ),
 *        @OA\Property(
 *            property="title",
 *            type="string",
 *            example="Example title"
 *        ),
 *        @OA\Property(
 *            property="description",
 *            type="string",
 *            example="Example description"
 *        ),
 *        @OA\Property(
 *            property="publication_date",
 *            type="datetime",
 *            example="2023-02-28 13:23:03"
 *        ),
 *        @OA\Property(
 *            property="author",
 *            type="string",
 *            example="Example Author"
 *        ),
 *        @OA\Property(
 *            property="media",
 *            type="array",
 *            @OA\Items(ref="#/components/schemas/MediaResource")
 *        )
 * )
 * @package App\Http\Resources
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Article $this */

        return $this->processVisibleFields($request->query('fields')) ?? [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'publication_date' => $this->publication_date,
            'author' => $this->author,
            'media' => MediaResource::collection($this->media)
        ];
    }

    protected function processVisibleFields(?array $fields): ?array
    {
        /** @var Article $this */
        if (is_null($fields)) {
            return null;
        }

        $output = [];
        foreach ($fields as $field) {
            if (in_array($field, array_merge($this->getFillable(), $this->getRelations()))) {
                $output[$field] = $this->$field;
            }
        }

        return empty($output) ? null : $output;
    }
}
