<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Livewire\Attributes\On;

trait HasStatusChange
{
    #[On('status-changed')]
    public function statusChanged(int $recordId, string $status): void
    {
        $this->onStatusChanged($recordId, $status);
    }

    public function onStatusChanged(int $recordId, string $status): void
    {
        //
    }
}
