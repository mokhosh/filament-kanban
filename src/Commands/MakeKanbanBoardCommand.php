<?php

namespace Mokhosh\FilamentKanban\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeKanbanBoardCommand extends GeneratorCommand
{
    public $name = 'make:kanban';

    public $description = 'Create a filament kanban board page';

    public $type = 'Kanban page';

    protected function getStub()
    {
        return file_exists($customPath = $this->laravel->basePath('/stubs/filament-kanban/board.stub'))
            ? $customPath
            : __DIR__ . '/../../stubs/board.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Filament\Pages';
    }
}
