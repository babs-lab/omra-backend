<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    public function index(): JsonResponse
    {
        $menus = MenuItem::active()->get(['label', 'route', 'url', 'is_external', 'position']);

        return response()->json($menus);
    }
}
