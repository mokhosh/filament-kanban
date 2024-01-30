@props(['status'])

<div class="md:w-[24rem] flex-shrink-0 min-h-full flex flex-col">
    @include(static::$headerView)

    <div
        id="{{ $status['id'] }}"
        class="flex flex-col flex-1 gap-2 p-3 bg-gray-200 dark:bg-gray-800 rounded-xl"
    >
        @foreach($status['records'] as $record)
            @include(static::$recordView)
        @endforeach
    </div>
</div>
