<x-filament-panels::page>
    <div class="flex">
        @foreach($statuses as $status)
            <div class="w-56">
                <h3>{{ $status['title'] }}</h3>

                <div>
                    @foreach($status['records'] as $record)
                        <div>{{ $record['title'] }}</div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
