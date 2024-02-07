<?php

namespace Mokhosh\FilamentKanban\Tests\Pages;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Mokhosh\FilamentKanban\Tests\Enums\TaskStatus;
use Mokhosh\FilamentKanban\Tests\Models\Task;

class TestBoard extends KanbanBoard
{
    protected static ?string $model = Task::class;

    protected function statuses(): Collection
    {
        return TaskStatus::statuses();
    }

    protected function getEditModalFormSchema(?int $recordId): array
    {
        return [
            TextInput::make('title'),
        ];
    }
}
