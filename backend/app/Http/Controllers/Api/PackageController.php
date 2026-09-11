<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\JsonResponse;

class PackageController extends Controller
{
    private function loadWithRelations($query)
    {
        return $query->with([
            'currency',
            'departures.currency',
            'departures.hotels' => fn($q) => $q->with('city'),
        ]);
    }

    private function mapCurrency($currency): ?array
    {
        return $currency
            ? ['code' => $currency->code, 'symbol' => $currency->symbol]
            : null;
    }

    private function mapPackage($package): array
    {
        $data = $package->toArray();
        $data['currency'] = $this->mapCurrency($package->currency);
        unset($data['currency_id']);

        $data['departures'] = $package->departures->map(function ($departure): array {
            $item = $departure->toArray();
            $item['currency'] = $this->mapCurrency($departure->currency);
            unset($item['currency_id']);
            return $item;
        })->values();

        return $data;
    }

    public function index(): JsonResponse
    {
        $packages = $this->loadWithRelations(Package::query())->get();

        return response()->json($packages->map(fn($p) => $this->mapPackage($p))->values());
    }

    public function show(string $slug): JsonResponse
    {
        $package = $this->loadWithRelations(
            Package::where('slug', $slug)
        )->firstOrFail();

        return response()->json($this->mapPackage($package));
    }
}
