<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Filament\Forms\Form;

trait HasEditRecordModal
{
    public array $editModalFormState = [];

    public ?int $editModalRecordId = null;

    protected string $editModalTitle = 'Edit Record';

    protected string $editModalWidth = '2xl';

    protected string $editModalSaveButtonLabel = "Save";

    protected string $editModalCancelButtonLabel = "Cancel";

    public function recordClicked(int $recordId, array $data): void
    {
        $this->editModalRecordId = $recordId;

        $this->form->fill($this->getEditModalRecordData($recordId, $data));

        $this->dispatch('open-modal', id: 'kanban--edit-record-modal');
    }

    public function editModalFormSubmitted(): void
    {
        $this->editRecord($this->editModalRecordId, $this->form->getState(), $this->editModalFormState);

        $this->editModalRecordId = null;
        $this->form->fill();

        $this->dispatch('close-modal', id: 'kanban--edit-record-modal');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getEditModalFormSchema($this->editModalRecordId))
            ->statePath('editModalFormState');
    }

    protected function getEditModalRecordData(int $recordId, array $data): array
    {
        return $data;
    }

    protected function editRecord(int $recordId, array $data, array $state): void
    {
        //
    }

    protected function getEditModalFormSchema(int|null $recordId): array
    {
        return [];
    }

    protected function getEditModalTitle(): string
    {
        return $this->editModalTitle;
    }

    protected function getEditModalWidth(): string
    {
        return $this->editModalWidth;
    }

    protected function getEditModalSaveButtonLabel(): string
    {
        return $this->editModalSaveButtonLabel;
    }

    protected function getEditModalCancelButtonLabel(): string
    {
        return $this->editModalCancelButtonLabel;
    }
}
