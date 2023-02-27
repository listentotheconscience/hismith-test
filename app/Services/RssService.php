<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\TransferStats;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\Response;

class RssService
{
    public const RSS_URL = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function getRss(): array
    {
        /** @var RequestLogService $requestLogService */
        $requestLogService = resolve(RequestLogService::class);

        $client = new Client();
        $response = $client->get(self::RSS_URL, [
            'on_stats' => function (TransferStats $stats) use ($requestLogService) {
                return $requestLogService->create($stats);
            }
        ]);
        return $this->transformResponseToArray($response->getBody());
    }

    /**
     * @param StreamInterface $response
     * @return array
     */
    public function transformResponseToArray(StreamInterface $response): array
    {
        $xmlObject = simplexml_load_string($response);

        if (!$xmlObject) {
            return [];
        }

        $jsonString = json_encode($xmlObject);
        return json_decode($jsonString, true);
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function process(): void
    {
        /** @var ArticleService $articleService */
        $articleService = resolve(ArticleService::class);

        /** @var MediaService $mediaService */
        $mediaService = resolve(MediaService::class);

        $data = $this->getRss();
        $created = 0;
        $skipped = 0;
        foreach ($data['channel']['item'] as $item) {
            try {
                $article = $articleService->create([
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'publication_date' => $item['pubDate'],
                    'author' => $item['author'] ?? null,
                ]);
                if (isset($item['enclosure'])) {
                    $mediaService->processMedia($item['enclosure'], $article);
                }
                $created++;
            } catch (\Exception $e) {
                $skipped++;
                continue;
            }
        }
    }
}
