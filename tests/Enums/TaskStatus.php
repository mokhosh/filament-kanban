<?php

namespace Mokhosh\FilamentKanban\Tests\Enums;

use Mokhosh\FilamentKanban\Concerns\KanbanStatusEnum;

enum TaskStatus: string
{
    use KanbanStatusEnum;

    case Todo = 'Todo';
    case Doing = 'Doing';
    case Done = 'Done';
}
