<?php

namespace Mokhosh\FilamentKanban\Resources\Pages;

use UnitEnum;
use Filament\Resources\Pages\Page;
use Mokhosh\FilamentKanban\Concerns\HasKanbanPage;

abstract class KanbanBoard extends Page
{
    use HasKanbanPage;

    protected static string $model;

    protected static string $statusEnum;

    protected static string $resource;
}
