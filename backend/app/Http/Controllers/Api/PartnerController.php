<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;

class PartnerController extends Controller
{
    public function index(): JsonResponse
    {
        $partners = Partner::active()->get(['name', 'logo', 'url', 'position'])->append('logo_url');

        return response()->json($partners);
    }
}
