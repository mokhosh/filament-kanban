<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

/** @deprecated Not necessary anymore. Can safely be removed. */
trait HasRecentUpdateIndication
{
    public function justUpdated(): Attribute
    {
        return Attribute::make(
            get: fn () => now()->diffInSeconds($this->{static::UPDATED_AT}) < 3,
        );
    }
}
