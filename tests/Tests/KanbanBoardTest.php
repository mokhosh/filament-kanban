<?php

use Mokhosh\FilamentKanban\Tests\Enums\TaskStatus;
use Mokhosh\FilamentKanban\Tests\Models\Task;
use Mokhosh\FilamentKanban\Tests\Pages\TestBoard;
use Mokhosh\FilamentKanban\Tests\Pages\TestBoardWithCustomViews;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can make kanban board from the stub', function () {
    $pagesPath = $this->app->basePath('app/Filament/Pages');

    $this->artisan('make:kanban TestBoard')->assertExitCode(0);

    expect($pagesPath . '/TestBoard.php')
        ->toBeFile()
        ->toContainAsFile('class TestBoard extends KanbanBoard');
});

it('loads statuses', function () {
    $statuses = TaskStatus::statuses()
        ->pluck('title')
        ->toArray();

    actingAs($this->admin)
        ->get(TestBoard::getUrl())
        ->assertSeeInOrder($statuses);
});

it('loads records', function () {
    $task = Task::factory()->create();

    actingAs($this->admin)
        ->get(TestBoard::getUrl())
        ->assertSee($task->title);
});

it('loads custom views', function () {
    $task = Task::factory()->create();

    actingAs($this->admin)
        ->get(TestBoardWithCustomViews::getUrl())
        ->assertSee($task->title);
});

it('changes status', function () {
    $task = Task::factory()->todo()->create();

    livewire(TestBoard::class)
        ->dispatch('status-changed', $task->id, TaskStatus::Done->value, [], []);

    expect($task->fresh()->status)->toBe(TaskStatus::Done);
});

it('changes sort', function () {
    [$task1, $task2] = Task::factory(2)->create();

    expect($task1->order_column)
        ->toBe(1);

    livewire(TestBoard::class)
        ->dispatch('sort-changed', $task1->id, TaskStatus::Todo->value, [$task2->id, $task1->id]);

    expect($task1->fresh()->order_column)
        ->toBe(2);
});

it('shows record edit modal', function () {
    $task = Task::factory()->todo()->create();

    livewire(TestBoard::class)
        ->assertSee('Edit Record')
        ->call('recordClicked', $task->id, [])
        ->assertDispatched('open-modal', id: 'kanban--edit-record-modal');
});

it('can hide record edit modal', function () {
    livewire(TestBoard::class)
        ->set('disableEditModal', true)
        ->assertDontSee('Edit Record');
});

it('edits records', function () {
    $task = Task::factory()->todo()->create();

    livewire(TestBoard::class)
        ->call('recordClicked', $task->id, [])
        ->set('editModalFormState.title', $newTitle = 'New Title')
        ->call('editModalFormSubmitted')
        ->assertDispatched('close-modal', id: 'kanban--edit-record-modal');

    expect($task->fresh()->title)
        ->toBe($newTitle);
});

it('saves relationships', function () {
    $task = Task::factory()->create();

    livewire(TestBoard::class)
        ->call('recordClicked', $task->id, [])
        ->set('editModalFormState.team', [1])
        ->call('editModalFormSubmitted');

    expect($task->fresh()->team)
        ->not->toBeEmpty();
});
