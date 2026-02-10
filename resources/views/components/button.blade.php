@props(['variant' => 'primary', 'href' => '#'])

@php
    $baseClasses = 'inline-flex items-center justify-center px-8 py-3.5 rounded-full font-heading font-bold text-base transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95';
    
    $variants = [
        'primary' => 'bg-primary text-white shadow-[0_4px_14px_0_rgba(31,175,90,0.39)] hover:bg-green-600 hover:shadow-[0_6px_20px_0_rgba(31,175,90,0.5)]',
        'secondary' => 'bg-secondary text-white shadow-lg hover:bg-slate-800',
        'outline' => 'border-2 border-primary text-primary hover:bg-primary hover:text-white',
        'accent' => 'bg-accent text-white shadow-[0_4px_14px_0_rgba(46,197,255,0.39)] hover:bg-blue-400',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href != '#')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
