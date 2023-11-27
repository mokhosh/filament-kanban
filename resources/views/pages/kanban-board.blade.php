<x-filament-panels::page>
    <div class="md:flex overflow-x-auto gap-6">
        @foreach($statuses as $status)
            <div class="md:w-[24rem] flex-shrink-0">
                <h3 class="font-semibold text-lg text-gray-400 mb-4">{{ $status['title'] }}</h3>

                <div class="flex flex-col gap-2">
                    @foreach($status['records'] as $record)
                        <div class="bg-white rounded border px-4 py-2 cursor-grab font-medium text-gray-600">{{ $record['title'] }}</div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
