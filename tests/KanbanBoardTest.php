<?php

use Mokhosh\FilamentKanban\Tests\Enums\TaskStatus;
use Mokhosh\FilamentKanban\Tests\Models\Task;
use Mokhosh\FilamentKanban\Tests\Pages\TestBoard;
use function Pest\Laravel\actingAs;

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
