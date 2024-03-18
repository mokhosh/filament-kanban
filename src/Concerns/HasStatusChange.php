<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Livewire\Attributes\On;

trait HasStatusChange
{
    #[On('status-changed')]
    public function statusChanged(int | string $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        $this->onStatusChanged($recordId, $status, $fromOrderedIds, $toOrderedIds);
    }

    public function onStatusChanged(int | string $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        $this->getEloquentQuery()->find($recordId)->update([
            static::$recordStatusAttribute => $status,
        ]);

        if (method_exists(static::$model, 'setNewOrder')) {
            static::$model::setNewOrder($toOrderedIds);
        }
    }

    #[On('sort-changed')]
    public function sortChanged(int | string $recordId, string $status, array $orderedIds): void
    {
        $this->onSortChanged($recordId, $status, $orderedIds);
    }

    public function onSortChanged(int | string $recordId, string $status, array $orderedIds): void
    {
        if (method_exists(static::$model, 'setNewOrder')) {
            static::$model::setNewOrder($orderedIds);
        }
    }
}
