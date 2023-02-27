<?php

namespace App\Services;

use App\Models\RequestLog;
use GuzzleHttp\TransferStats;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RequestLogService
{
    public function create(TransferStats $stats): Builder|Model
    {
        return RequestLog::query()->create([
            'request_method' => $stats->getRequest()->getMethod(),
            'request_url' => $stats->getRequest()->getUri(),
            'response_code' => $stats->getResponse()->getStatusCode(),
            'response_body' => $stats->getResponse()->getBody(),
            'response_time' => round($stats->getTransferTime() * 1000)
        ]);
    }
}
