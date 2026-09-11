<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use Illuminate\Contracts\Support\Renderable;
use MoonShine\UI\Fields\Image;

class LogoPreview extends Image
{
    protected function resolvePreview(): Renderable|string
    {
        $src = $this->getFiles()->first()?->getFullPath();

        if ($src === null) {
            return '';
        }

        return '<div class="flex">
            <img
                src="' . e($src) . '"
                alt=""
                style="max-height:56px;max-width:140px;width:auto;height:auto;object-fit:contain;border:1px solid #e2e8f0;border-radius:6px;padding:4px;background:#fff"
                loading="lazy"
            >
        </div>';
    }
}
