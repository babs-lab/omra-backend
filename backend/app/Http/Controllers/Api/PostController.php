<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Post::published()
            ->get(['title', 'slug', 'excerpt', 'cover_image', 'position'])
            ->append('cover_image_url');

        return response()->json($posts);
    }

    public function show(string $slug): JsonResponse
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->first(['id', 'title', 'slug', 'excerpt', 'content', 'cover_image', 'position'])
            ?->append('cover_image_url');

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);
    }
}
