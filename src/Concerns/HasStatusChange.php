<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Livewire\Attributes\On;

trait HasStatusChange
{
    #[On('status-changed')]
    public function statusChanged($recordId, $status)
    {
        $this->onStatusChanged($recordId, $status);
    }

    public function onStatusChanged($recordId, $status)
    {
        //
    }
}
