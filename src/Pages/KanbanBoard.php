<?php

namespace Mokhosh\FilamentKanban\Pages;

use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Concerns\HasEditRecordModal;
use Mokhosh\FilamentKanban\Concerns\HasStatusChange;
use UnitEnum;

class KanbanBoard extends Page implements HasForms
{
    use HasEditRecordModal;
    use HasStatusChange;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament-kanban::kanban-board';

    protected static string $headerView = 'filament-kanban::kanban-header';

    protected static string $recordView = 'filament-kanban::kanban-record';

    protected static string $statusView = 'filament-kanban::kanban-status';

    protected static string $scriptsView = 'filament-kanban::kanban-scripts';

    protected static ?string $model = null;

    protected static string $recordTitleAttribute = 'title';

    protected static string $recordStatusAttribute = 'status';

    protected function statuses(): Collection
    {
        return collect();
    }

    protected function records(): Collection
    {
        return static::$model::get();
    }

    protected function getViewData(): array
    {
        $records = $this->records()
            ->map($this->transformRecords(...));
        $statuses = $this->statuses()
            ->map(function ($status) use ($records) {
                $status['records'] = $records->where('status', $status['id'])->all();

                return $status;
            });

        return [
            'statuses' => $statuses,
        ];
    }

    protected function transformRecords(Model $record): Collection
    {
        return collect([
            'id' => $record->id,
            'title' => $record->{static::$recordTitleAttribute},
            'status' => $record->{static::$recordStatusAttribute} instanceof UnitEnum ?
                $record->{static::$recordStatusAttribute}->value :
                $record->{static::$recordStatusAttribute},
            'just_updated' => $record->updated_at->diffInSeconds(now()) < 3,
        ])->merge($this->additionalRecordData($record));
    }

    protected function additionalRecordData(Model $record): Collection
    {
        return collect([]);
    }
}
