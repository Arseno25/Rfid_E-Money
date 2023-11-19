<?php

namespace App\Models\States\Status;

class Inactive extends StatusState
{
    public static string $name = 'inactive';

    public function color(): string
    {
        return 'danger';
    }

    public function label(): string
    {
        return 'Inactive';
    }

    public function toLivewire(): static
    {
        return new static(static::getModel());
    }

    public static function fromLivewire($value)
    {
        return $value;
    }
}
