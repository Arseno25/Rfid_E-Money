<?php

namespace App\Models\States\OrderStatus;

class Failed extends StatusState
{
    public static string $name = 'failed';

    public function color(): string
    {
        return 'danger';
    }

    public function label(): string
    {
        return 'Failed';
    }

    public function key(): string
    {
        return 'failed';
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
