<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'publication_date' => $this->publication_date,
            'author' => $this->author,
            'media' => MediaResource::collection($this->media)
        ];
    }
}
