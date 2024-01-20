@props(['status'])

<div class="md:w-[24rem] flex-shrink-0 min-h-full flex flex-col">
    @include('filament-kanban::kanban-header')

    <div
        id="{{ $status['id'] }}"
        class="flex flex-col flex-1 gap-2 p-3 bg-gray-200 dark:bg-gray-800 rounded-xl"
    >
        @foreach($status['records'] as $record)
            @include('filament-kanban::kanban-record')
        @endforeach
    </div>
</div>
