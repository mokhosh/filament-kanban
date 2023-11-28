<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Livewire\Attributes\On;

trait RespondsToStatusChange
{
    #[On('status-changed')]
    public function statusChanged($record, $status)
    {
        $this->onStatusChanged($record, $status);
    }

    protected function onStatusChanged($record, $status)
    {
        dd($record, $status);
    }
}
