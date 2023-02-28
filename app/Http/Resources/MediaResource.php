<?php

namespace App\Http\Resources;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use OpenApi\Annotations as OA;

/**
 * Media list resource
 *
 * @OA\Schema(
 *     @OA\Property(
 *          property="url",
 *          type="string",
 *          example="https://temp-url.exmaple/sample.jpg"
 *     )
 * )
 *
 * @package App\Http\Resources
 */
class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Media $this */
        return [
            'url' => Storage::disk('public')->url($this->url)
        ];
    }
}
