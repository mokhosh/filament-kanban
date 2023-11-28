<x-filament-panels::page>
    <div x-data class="md:flex overflow-x-auto">
        @foreach($statuses as $status)
            <div class="md:w-[24rem] flex-shrink-0">
                <h3 class="px-4 font-semibold text-lg text-gray-400">{{ $status['title'] }}</h3>

                <div
                    id="{{ $status['id'] }}"
                    x-on:dragover.self.prevent="
                        const dragged = document.querySelector('.is-dragging')
                        const top = $event.target.querySelector('.record:not(.is-dragging)')
                        $event.target.insertBefore(dragged, top)
                    "
                    class="flex flex-col gap-2 p-4"
                >
                    @foreach($status['records'] as $record)
                        <div
                            id="{{ $record['id'] }}"
                            x-on:dragstart="$event.target.classList.add(...'!bg-gray-700 text-white is-dragging'.split(' '))"
                            x-on:dragend="
                                $event.target.classList.remove(...'!bg-gray-700 text-white is-dragging'.split(' '))
                                $dispatch('status-changed', {record: $event.target.id, status: $event.target.parentElement.id})
                            "
                            draggable="true"
                            class="record bg-white rounded border px-4 py-2 cursor-grab active:cursor-grabbing font-medium text-gray-600"
                        >
                            {{ $record['title'] }}
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
