@props(['title', 'subtitle' => '', 'align' => 'center', 'dark' => false])

<div class="{{ $align === 'center' ? 'text-center' : ($align === 'right' ? 'text-right' : 'text-left') }} mb-16 sm:mb-20">
    @if($subtitle)
        <span class="{{ $dark ? 'text-accent' : 'text-primary' }} font-black tracking-[0.3em] uppercase text-[10px] sm:text-xs block mb-4 animate-fade-in-up">
            {{ $subtitle }}
        </span>
    @endif
    <h2 class="text-3xl sm:text-4xl md:text-6xl font-heading font-black {{ $dark ? 'text-white' : 'text-secondary' }} leading-[1.1] tracking-tight mb-6">
        {!! $title !!}
    </h2>
    <div class="flex {{ $align === 'center' ? 'justify-center' : ($align === 'right' ? 'justify-end' : 'justify-start') }}">
        <div class="h-1.5 w-16 bg-primary rounded-full relative overflow-hidden">
            <div class="absolute inset-0 bg-white/30 skew-x-[45deg] animate-pulse"></div>
        </div>
    </div>
</div>
