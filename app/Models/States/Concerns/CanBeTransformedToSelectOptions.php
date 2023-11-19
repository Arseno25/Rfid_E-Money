<?php

namespace App\Models\States\Concerns;

use Spatie\LaravelOptions\Options;

trait CanBeTransformedToSelectOptions
{
    /**
     * Get dropdown select options for filament select options
     */
    public static function getSelectOptions(): array
    {
        $data = Options::forStates(static::class);

        return collect($data)->mapWithKeys(function ($item, $key) {
            return [$item['value'] => $item['label']];
        })->toArray();
    }
}
