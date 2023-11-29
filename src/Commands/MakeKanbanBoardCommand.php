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
        return __DIR__ . '/../../stubs/board.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Filament\Pages';
    }
}
