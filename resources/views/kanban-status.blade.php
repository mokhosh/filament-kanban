@props(['status'])

@php
    $title = $status['title'] ?? '';
    $color = $status['color'] ?? '';
@endphp

<div class="panel flex-1 mb-5 md:min-h-full flex flex-col" id="{{ $status['id'] }}">
    <div class="min-h-[150px]">
        <div class="flex justify-between">
            @include(static::$headerView)

            <div x-on:click="hideElement('{{ $status['id'] }}', '{{ $title }}', '{{ $color }}');">
                @svg('heroicon-o-eye-slash', ['class' => 'text-gray-400 w-5 h-5'])
            </div>
        </div>

        <div
                data-status-id="{{ $status['id'] }}"
                class="flex flex-col flex-1"
        >
            @foreach($status['records'] as $record)
                @include(static::$recordView)
            @endforeach
        </div>
    </div>
</div>

<script>
  function hideElement(status, title, color) {
    const visibleElement = document.getElementById(status);

    visibleElement.classList.add('hidden');

    const textnode = `<span class="flex items-center" id="hidden_`+ status +`" x-on:click="showElement('`+ status +`');">
                @svg('heroicon-o-eye', ['class' => 'text-`+ color +` w-5 h-5']) <span class="pl-1 text-`+ color +`">`+ title +`</span>
        </span>`;

    document.getElementById("hiddenItems")
      .innerHTML += textnode;
  }

  function showElement(status) {
    const hiddenElement = document.getElementById(status);
    hiddenElement.classList.remove('hidden');

    const removeHidden = document.getElementById('hidden_' + status);
    removeHidden.remove();
  }
</script>
