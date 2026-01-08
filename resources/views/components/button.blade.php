<div>
    @props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary', 
])

@php
    $base = 'px-4 py-2 rounded text-sm sm:text-base inline-block font-medium transition';
    $variants = [
        'primary' => 'bg-green-600 hover:bg-green-700 text-white',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
    ];
    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

</div>