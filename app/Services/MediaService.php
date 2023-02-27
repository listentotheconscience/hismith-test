<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Media;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    private array $MIMES = [
        'image/png', 'image/jpeg'
    ];

    /**
     * @param array $item
     * @return string|null
     */
    private function saveMediaFromUrl(array $item): ?string
    {
        if (!$this->isImage($item['type'])) {
            return null;
        }

        $fileName = md5(microtime(true));
        $extension = str($item['url'])->explode('.')->last();

        Storage::disk('public')->put("$fileName.$extension", file_get_contents($item['url']));

        return "$fileName.$extension";
    }

    /**
     * @param string $mime
     * @return bool
     */
    private function isImage(string $mime): bool
    {
        return in_array($mime, $this->MIMES);
    }

    /**
     * @param array $media
     * @param Article $article
     * @return void
     */
    public function processMedia(array $media, Article $article): void
    {
        if ($article->media->isNotEmpty()) {
            return;
        }

        if (Arr::has($media, '@attributes')) {
            $fileName = $this->saveMediaFromUrl($media['@attributes']);
            if (is_null($fileName)) {
                return;
            }

            Media::query()->create([
                'article_id' => $article->id,
                'url' => $fileName
            ]);
        } else {
            foreach ($media as $item) {
                $this->processMedia($item, $article);
            }
        }
    }
}
