<?php

namespace Mokhosh\FilamentKanban\Commands;

use Illuminate\Console\Command;

class FilamentKanbanCommand extends Command
{
    public $signature = 'filament-kanban';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
