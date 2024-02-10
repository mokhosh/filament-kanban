<?php

use Mokhosh\FilamentKanban\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

expect()->extend('toContainAsFile', function ($needle) {
    expect(file_get_contents($this->value))
        ->toContain($needle);

    return $this;
});
