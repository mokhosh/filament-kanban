<div id="{{ $record->getKey() }}" wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
     class="record shadow bg-[#f4f4f4] dark:bg-[#262e40] px-4 py-2 cursor-grab rounded-lg mb-5 space-y-3 text-sm"
     @if($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}) < 3)
             x-data
             x-init="
                $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')
                $el.classList.remove('bg-[#f4f4f4]', 'dark:bg-[#262e40]')
                setTimeout(() => {
                    $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')
                    $el.classList.add('bg-[#f4f4f4]', 'dark:bg-[#262e40]')
                }, 3000)"
        @endif
>
        <div class="font-semibold mb-2">
                {{ $record->{static::$recordTitleAttribute} }}
        </div>
</div>