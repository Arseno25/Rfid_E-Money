<?php

namespace App\Models\States\OrderStatus;

use App\Models\States\Concerns\CanBeTransformedToSelectOptions;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
use Livewire\Wireable;

abstract class StatusState extends State implements Wireable
{
    use CanBeTransformedToSelectOptions;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Failed::class)
            ->allowTransitions([
                [Failed::class, Success::class],
                [Success::class, Failed::class],
            ]);
    }

    /**
     * Get pre-defined color
     */
    abstract public function color(): string;

    /**
     * Get pre-defined label
     */
    abstract public function label(): string;

    abstract public function key(): string;
}
