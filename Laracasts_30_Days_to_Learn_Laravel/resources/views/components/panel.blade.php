@php
    $classes = 'p-4 transition-colors duration-300 border border-transparent bg-white/5 rounded-xl hover:border-blue-800 group';
@endphp

<div {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</div>
