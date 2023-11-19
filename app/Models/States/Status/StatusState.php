<?php

namespace App\Models\States\Status;

use App\Models\States\Concerns\CanBeTransformedToSelectOptions;
use App\Models\States\Status\Inactive;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
use Livewire\Wireable;

abstract class StatusState extends State implements Wireable
{
    use CanBeTransformedToSelectOptions;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Inactive::class)
            ->allowTransitions([
                [Inactive::class, Active::class],
                [Active::class, Inactive::class],
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
}
