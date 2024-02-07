<?php

namespace Mokhosh\FilamentKanban\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Task extends Model implements Sortable
{
    use SortableTrait;

    protected $guarded = [];
}
