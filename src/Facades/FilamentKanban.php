<?php

namespace Mokhosh\FilamentKanban\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mokhosh\FilamentKanban\FilamentKanban
 */
class FilamentKanban extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mokhosh\FilamentKanban\FilamentKanban::class;
    }
}
