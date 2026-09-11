<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    public function index(): JsonResponse
    {
        $currencies = Currency::active()->get(['id', 'code', 'name', 'symbol', 'exchange_rate']);

        return response()->json($currencies);
    }
}
