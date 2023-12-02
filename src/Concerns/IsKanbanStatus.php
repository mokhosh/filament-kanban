<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Illuminate\Support\Collection;

trait IsKanbanStatus
{
    public static function statuses(): Collection
    {
        return collect(static::kanbanCases())
            ->map(function (self $item) {
                return [
                    'id' => $item->getId(),
                    'title' => $item->getTitle(),
                ];
            });
    }

    public static function kanbanCases(): array
    {
        return static::cases();
    }

    public function getId(): string
    {
        return $this->value;
    }

    public function getTitle(): string
    {
        return $this->value;
    }
}
