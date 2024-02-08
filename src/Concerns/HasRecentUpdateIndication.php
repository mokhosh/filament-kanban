<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/** @mixin Model */
trait HasRecentUpdateIndication
{
    public function justUpdated(): Attribute
    {
        return Attribute::make(
            get: fn () => now()->diffInSeconds($this->{static::UPDATED_AT}) < 3,
        );
    }
}
