<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $target = $request->query('target', 'homepage');

        $sections = Section::active()
            ->forTargetPage($target)
            ->ordered()
            ->get(['title', 'slug', 'content', 'target_page', 'position', 'style']);

        return response()->json($sections);
    }
}
