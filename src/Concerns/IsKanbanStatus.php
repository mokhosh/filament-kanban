<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Illuminate\Support\Collection;

trait IsKanbanStatus
{
    public static function statuses(): Collection
    {
        return collect(static::cases())
            ->map(function (self $item) {
                return [
                    'id' => $item->getId(),
                    'title' => $item->getTitle(),
                ];
            });
    }

    public function getId(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->value;
    }
}
