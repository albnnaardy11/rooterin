@props(['image', 'title', 'category'])

<div class="group relative overflow-hidden rounded-2xl aspect-square shadow-md hover:shadow-2xl transition-all duration-500 cursor-pointer">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
    <div class="absolute inset-0 bg-gradient-to-t from-secondary/90 via-secondary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
        <span class="text-accent text-xs font-bold uppercase tracking-wider mb-1 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75">{{ $category }}</span>
        <h4 class="text-white font-heading font-bold text-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">{{ $title }}</h4>
    </div>
</div>
