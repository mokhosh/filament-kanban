<?php

namespace Mokhosh\FilamentKanban\Pages;

use Filament\Pages\Page;

class KanbanBoard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.kanban-board';

    protected function statuses(): array
    {
        return [
            'pitching',
            'onboarding',
        ];
    }

    protected function getViewData(): array
    {
        return [
            'statuses' => $this->statuses(),
        ];
    }
}
