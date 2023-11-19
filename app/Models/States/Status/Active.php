<?php

namespace App\Models\States\Status;

class Active extends StatusState
{
    public static string $name = 'active';

    public function color(): string
    {
        return 'success';
    }

    public function label(): string
    {
        return 'Active';
    }

    public function key(): string
    {
        return 'active';
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
