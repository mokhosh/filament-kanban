<?php

namespace Mokhosh\FilamentKanban\Tests\Pages;

use Filament\Forms;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Mokhosh\FilamentKanban\Tests\Enums\TaskStatus;
use Mokhosh\FilamentKanban\Tests\Models\Task;
use Mokhosh\FilamentKanban\Tests\Models\User;

class TestBoard extends KanbanBoard
{
    protected static string $model = Task::class;

    protected static string $statusEnum = TaskStatus::class;

    protected function getEditModalFormSchema(null | int | string $recordId): array
    {
        return [
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\Select::make('team')
                ->relationship('team', 'name')
                ->multiple()
                ->options(User::pluck('name', 'id')),
        ];
    }
}
