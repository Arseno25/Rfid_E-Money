<?php

namespace App\Models\States\OrderStatus;

class Success extends StatusState
{
    public static string $name = 'success';

    public function color(): string
    {
        return 'primary';
    }

    public function label(): string
    {
        return 'Success';
    }

    public function key(): string
    {
        return 'success';
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
