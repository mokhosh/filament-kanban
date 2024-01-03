@props(['status'])

<div class="md:w-[24rem] flex-shrink-0">
    @include('filament-kanban::kanban-header')

    <div
        id="{{ $status['id'] }}"
        class="flex flex-col gap-2 p-4 min-h-full"
    >
        @foreach($status['records'] as $record)
            @include('filament-kanban::kanban-record')
        @endforeach
    </div>
</div>
