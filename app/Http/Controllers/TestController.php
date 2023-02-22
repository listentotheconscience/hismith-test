<?php

namespace App\Http\Controllers;

use App\Services\RssService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request, RssService $rssService)
    {
        return response($rssService->parse($rssService->getRss()));
    }
}
