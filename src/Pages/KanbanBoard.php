<?php

namespace Mokhosh\FilamentKanban\Pages;

use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
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

    /**
     * The cardTitle property defines the database column or HTML content
     * that will be used to display the title for each record in the Kanban board.
     *
     * By default, this is set to 'title' which will display the title attribute
     * of each record. However, you can override this and return any HTMLable
     * object to fully customize the content and styling for each card.
     *
     * For example:
     *
     * ```php
     * public function getCardTitle(?Model $record) {
     *   return new HtmlString('<span>'.$record->uuid.'</span><h3>'.$record->title.'</h3>');
     * }
     * ```
     *
     * This would allow you to output custom HTML content for each record's card.
     *
     * @var string|Htmlable|callable
     */
    protected static $cardTitle = 'title';

    /**
     * The cardContent property defines the database column or HTML content
     * that will be used to display the card content for each record in the Kanban board.
     *
     * By default, this is set to 'null' which will not display anything
     * of each record. However, you can override this and return any HTMLable
     * object to fully customize the content and styling for each card.
     *
     * For example:
     *
     * ```php
     * public function getCardContent(?Model $record) {
     *   return new HtmlString('<b class="text-gray-300">'.$record->created_at->diffForHumans().'</b><br><p>'.$record->description.'</p>');
     * }
     * ```
     *
     * This would allow you to output custom HTML content for each record's card.
     *
     * @var null|string|Htmlable|callable
     */
    protected static $cardContent;

    protected static string $recordStatusAttribute = 'status';

    /**
     * If true, a divider will be shown under the card title.
     *
     * This can be used to visually separate the title from the rest of the
     * card content.
     */
    protected static bool $enableDividerAfterTitle = false;

    public function getCardTitle(?Model $record): string | Htmlable | null
    {
        return static::$cardTitle;
    }

    public function getCardContent(?Model $record): string | Htmlable | null
    {
        return static::$cardContent;
    }

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
        return collect(value: [
            'id' => $record->id,
            'title' => $this->determineCardTitle($record),
            'content' => $this->determineCardContent($record),
            'status' => $this->determineStatus($record),
        ])->merge($this->additionalRecordData($record));
    }

    protected function additionalRecordData(Model $record): Collection
    {
        return collect([]);
    }

    private function determineCardTitle(Model $record): mixed
    {
        $cardTitle = $this->getCardTitle($record);

        if (is_string($cardTitle) && array_key_exists($cardTitle, $record->getAttributes())) {
            return $record->{$cardTitle};
        }

        return $cardTitle;
    }

    private function determineCardContent(Model $record): mixed
    {
        $cardContent = $this->getCardContent($record);
        if (is_string($cardContent) && array_key_exists($cardContent, $record->getAttributes())) {
            return $record->{$cardContent};
        }

        return $cardContent;
    }

    private function determineStatus(Model $record): mixed
    {
        $recordStatus = $record->{static::$recordStatusAttribute};

        return ($recordStatus instanceof UnitEnum) ? $recordStatus->value : $recordStatus;
    }
}
