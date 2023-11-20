<?php

namespace Mokhosh\FilamentKanban\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Collection;

class KanbanBoard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.kanban-board';

    protected function statuses(): Collection
    {
        return collect();
    }

    protected function records(): Collection
    {
        return collect();
    }

    protected function getViewData(): array
    {
        $records = $this->records();
        $statuses = $this->statuses()
            ->map(function ($status) use ($records) {
                $status['records'] = $records->where('status', $status['id'])->all();

                return $status;
            });

        return [
            'statuses' => $statuses,
        ];
    }
}
