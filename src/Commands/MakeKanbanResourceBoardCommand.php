<?php

namespace Mokhosh\FilamentKanban\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeKanbanResourceBoardCommand extends GeneratorCommand
{
    public $name = 'make:resource-kanban';

    public $description = 'Create a filament kanban board page for a resource';

    public $type = 'Kanban page';

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/resource-board.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Filament\Resources\\'. $this->getResourceInput() .'\Pages';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getResourceInput()
    {
        return ucfirst(Str::camel(trim($this->argument('resource'))));
    }

    protected function getArguments()
    {
        return array_merge(parent::getArguments(), [
            ['resource', InputArgument::REQUIRED, 'The name of the resource to create the page in'],
        ]);
    }
}
