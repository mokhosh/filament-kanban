<?php

use Mokhosh\FilamentKanban\Tests\Enums\TaskStatus;
use Mokhosh\FilamentKanban\Tests\Models\Task;
use Mokhosh\FilamentKanban\Tests\Pages\TestBoard;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('loads statuses', function () {
    $statuses = TaskStatus::statuses()
        ->pluck('title')
        ->toArray();

    actingAs($this->admin)
        ->get(TestBoard::getUrl())
        ->assertSeeInOrder($statuses);
});

it('loads records', function () {
    $task = Task::create([
        'title' => 'First Task',
        'status' => 'Todo',
    ]);

    actingAs($this->admin)
        ->get(TestBoard::getUrl())
        ->assertSee($task->title);
});

it('changes status', function () {
    $task = Task::create([
        'title' => 'First Task',
        'status' => 'Todo',
    ]);

    livewire(TestBoard::class)
        ->call('onStatusChanged', $task->id, TaskStatus::Done->value, [], []);

    expect($task->fresh()->status)->toBe(TaskStatus::Done->value);
});

it('changes sort', function () {
    $task1 = Task::create([
        'title' => 'First Task',
        'status' => 'Todo',
    ]);
    $task2 = Task::create([
        'title' => 'Second Task',
        'status' => 'Todo',
    ]);

    expect($task1->order_column)
        ->toBe(1);

    livewire(TestBoard::class)
        ->call('onSortChanged', $task1->id, TaskStatus::Todo->value, [$task2->id, $task1->id]);

    expect($task1->fresh()->order_column)
        ->toBe(2);
});
