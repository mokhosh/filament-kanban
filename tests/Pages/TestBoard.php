<?php

namespace Mokhosh\FilamentKanban\Tests\Pages;

use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Mokhosh\FilamentKanban\Tests\Enums\TaskStatus;
use Mokhosh\FilamentKanban\Tests\Models\Task;

class TestBoard extends KanbanBoard
{
    protected static ?string $model = Task::class;

    protected static ?string $statusEnum = TaskStatus::class;
}
