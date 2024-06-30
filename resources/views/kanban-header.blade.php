@php
    $icon = $status['icon'];
    $color = $status['color'];
@endphp

<h3 @class(['mb-2 font-semibold text-sm',
    'text-'.$color => $color,
    'text-primary-400' => !$color,
    ])
>
<span class="inline-block align-middle">
    @if ($icon)
        @svg($icon)
    @else
        ❖
    @endif
</span>
    {{ $status['title'] }}
</h3>
