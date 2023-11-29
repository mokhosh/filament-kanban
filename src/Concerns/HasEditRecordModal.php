<?php

namespace Mokhosh\FilamentKanban\Concerns;

trait HasEditRecordModal
{
    public array $editModalFormState = [];

    public ?int $editModalRecordId = null;

    protected string $editModalTitle = 'Edit Record';

    protected string $editModalWidth = '2xl';

    protected string $editModalSaveButtonLabel = "Save";

    protected string $editModalCancelButtonLabel = "Cancel";

    public function recordClicked($recordId, $data): void
    {
        $this->editModalRecordId = $recordId;

        $this->editModalForm->fill($this->getEditModalRecordData($recordId, $data));

        $this->dispatch('open-modal', id: 'kanban--edit-modal-form');
    }

    public function getEditModalRecordData($recordId, $data): array
    {
        return $data;
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

    //

    public function onEditModalFormSubmit(): void
    {
        $this->editRecord($this->editModalRecordId, $this->editModalForm->getState(), $this->editModalFormState);

        $this->editModalRecordId = null;

        $this->dispatch('close-modal', id: 'kanban--edit-modal-form');
    }

    public function editRecord($recordId, array $data, array $state): void
    {
        // Override this function and do whatever you want with $data
    }

    protected function getEditModalFormSchema(int|null $recordId): array
    {
        return [];
    }

    protected function getEditModalForm(): array
    {
        return [
            'editModalForm' => $this->makeForm()
                ->schema($this->getEditModalFormSchema($this->editModalRecordId))
                ->statePath('editModalFormState'),
        ];
    }

    //

    protected function setUpForms(): void
    {
        $this->editModalForm->fill();
    }

    protected function getForms(): array
    {
        return array_merge(
            $this->getEditModalForm()
        );
    }
}
