<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::active()->get(['name', 'city', 'content', 'rating', 'avatar', 'position'])->append('avatar_url');

        return response()->json($testimonials);
    }
}
