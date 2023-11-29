<div
    id="{{ $record['id'] }}"
    wire:click="recordClicked('{{ $record['id'] }}', {{ @json_encode($record) }})"
    class="record bg-white rounded border px-4 py-2 cursor-grab font-medium text-gray-600"
>
    {{ $record['title'] }}
</div>
