<?php

namespace Mokhosh\FilamentKanban\Pages;

use Filament\Pages\Page;
use Mokhosh\FilamentKanban\Concerns\HasKanbanPage;

class KanbanBoard extends Page
{
    use HasKanbanPage;

    protected static string $model;

    protected static string $statusEnum;
}
