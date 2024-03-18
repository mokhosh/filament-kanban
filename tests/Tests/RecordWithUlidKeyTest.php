<?php

use Mokhosh\FilamentKanban\Tests\Enums\TaskStatus;
use Mokhosh\FilamentKanban\Tests\Models\UlidTask;
use Mokhosh\FilamentKanban\Tests\Pages\TestBoardWithUlidTask;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('loads records', function () {
    $task = UlidTask::factory()->create();

    actingAs($this->admin)
        ->get(TestBoardWithUlidTask::getUrl())
        ->assertSee($task->title);
});

it('changes status of records', function () {
    $task = UlidTask::factory()->create();

    livewire(TestBoardWithUlidTask::class)
        ->dispatch('status-changed', $task->getKey(), TaskStatus::Done->value, [], []);

    expect($task->fresh()->status)->toBe(TaskStatus::Done);
});

it('changes sort of records', function () {
    [$task1, $task2] = UlidTask::factory(2)->create();

    expect($task1->order_column)
        ->toBe(1);

    livewire(TestBoardWithUlidTask::class)
        ->dispatch('sort-changed', $task1->getKey(), TaskStatus::Todo->value, [$task2->getKey(), $task1->getKey()]);

    expect($task1->fresh()->order_column)
        ->toBe(2);
});

it('shows record edit modal', function () {
    $task = UlidTask::factory()->todo()->create();

    livewire(TestBoardWithUlidTask::class)
        ->assertSee('Edit Record')
        ->call('recordClicked', $task->getKey(), [])
        ->assertDispatched('open-modal', id: 'kanban--edit-record-modal');
});

it('edits records', function () {
    $task = UlidTask::factory()->todo()->create();

    livewire(TestBoardWithUlidTask::class)
        ->call('recordClicked', $task->getKey(), [])
        ->set('editModalFormState.title', $newTitle = 'New Title')
        ->call('editModalFormSubmitted')
        ->assertDispatched('close-modal', id: 'kanban--edit-record-modal');

    expect($task->fresh()->title)
        ->toBe($newTitle);
});
