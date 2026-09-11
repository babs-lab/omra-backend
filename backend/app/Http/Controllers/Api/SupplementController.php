<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplement;
use Illuminate\Http\JsonResponse;

class SupplementController extends Controller
{
    public function index(): JsonResponse
    {
        $supplements = Supplement::with('currency')->get();

        $data = $supplements->map(function (Supplement $supplement): array {
            $item = $supplement->toArray();
            $item['currency'] = $supplement->currency
                ? ['code' => $supplement->currency->code, 'symbol' => $supplement->currency->symbol]
                : null;
            unset($item['currency_id']);
            return $item;
        });

        return response()->json($data);
    }
}
