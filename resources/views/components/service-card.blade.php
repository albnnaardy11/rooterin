@props(['title', 'icon', 'description', 'price'])

<div class="flex flex-col group cursor-pointer">
    <!-- Visual Box -->
    <div class="relative aspect-square bg-[#F0F2F5] rounded-[2.5rem] mb-8 overflow-hidden transition-all duration-500 group-hover:bg-primary/5 group-hover:-translate-y-2 group-hover:shadow-2xl group-hover:shadow-primary/10">
        <!-- Abstract Shape/Icon Container -->
        <div class="absolute inset-0 flex items-center justify-center p-12">
            <div class="w-full h-full bg-white rounded-3xl shadow-sm flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-500 group-hover:bg-primary group-hover:text-white">
                <div class="w-16 h-16 sm:w-20 sm:h-20">
                    {{ $icon }}
                </div>
            </div>
        </div>
        
        <!-- Price Tag (Float subtlely) -->
        <div class="absolute top-6 right-6 px-4 py-1.5 bg-white/80 backdrop-blur-md rounded-full text-[10px] font-black text-secondary uppercase tracking-widest border border-white/20 shadow-sm">
            Mulai {{ $price }}
        </div>
    </div>

    <!-- Text Content (Below) -->
    <div class="px-2">
        <h3 class="font-heading font-black text-2xl text-secondary mb-3 group-hover:text-primary transition-colors tracking-tight">
            {{ $title }}.
        </h3>
        <p class="text-gray-500 text-base leading-relaxed font-medium opacity-80 group-hover:opacity-100 transition-opacity">
            {{ $description }}
        </p>
        
        <!-- CTA Link -->
        <a href="https://wa.me/6281234567890?text=Halo+Kak,+mau+tanya+dong+tentang+{{ urlencode($title) }}" 
           class="inline-flex items-center mt-6 text-primary font-bold text-sm group-hover:gap-3 transition-all">
            Konsultasi Sekarang 
            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </div>
</div>
