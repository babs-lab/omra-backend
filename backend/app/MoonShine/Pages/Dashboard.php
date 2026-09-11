<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Lead;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;

class Dashboard extends Page
{
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Dashboard';
    }

    protected function components(): iterable
    {
        $monthlyLeads = Lead::whereMonth('created_at', now()->month)->count();
        $pendingLeads = Lead::where('status', 'pending')->count();
        $totalLeads = Lead::count();

        return [
            ValueMetric::make('Leads du mois')->value((string) $monthlyLeads),
            ValueMetric::make('Leads en attente')->value((string) $pendingLeads),
            ValueMetric::make('Total leads')->value((string) $totalLeads),
        ];
    }
}
