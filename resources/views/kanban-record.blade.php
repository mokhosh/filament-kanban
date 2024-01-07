@php use Illuminate\Contracts\Support\Htmlable; @endphp
<div
    id="{{ $record['id'] }}"
    wire:click="recordClicked('{{ $record['id'] }}', {{ @json_encode($record) }})"
    class="record cursor-grab block max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
>

    @if($record['title'] instanceof Htmlable)
        {{$record['title']}}
    @elseif($record['title'])
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-primary-500 dark:text-primary-500">
            {{$record['title']}}
        </h5>
    @else
        {{-- Fallback to record ID if title is not set. --}}
        <h5>
            {{$record['id']}}
        </h5>
    @endif

    @if($record['content'] instanceof Htmlable)
        {{$record['content']}}
    @elseif($record['content'])
        <p class="font-normal text-gray-700 dark:text-gray-400">{{ $record['content'] }}</p>
    @endif


</div>
