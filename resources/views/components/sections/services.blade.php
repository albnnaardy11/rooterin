@props([
    'title' => 'Pilih Layanan Yang Anda Butuhkan',
    'subtitle' => 'SOLUSI TERLENGKAP',
    'services' => []
])

<section id="services" {{ $attributes->merge(['class' => 'py-24 sm:py-32 bg-stone-50 relative overflow-hidden']) }}>
    <!-- Background Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 mb-20">
            <div class="max-w-3xl">
                <x-section-heading 
                    title="Solusi Plumbing <span class='text-primary italic'>Modern & Tuntas.</span>" 
                    subtitle="PELAYANAN TERBAIK" 
                    align="left" 
                    class="!mb-0" 
                />
            </div>
            <x-button variant="secondary" href="{{ route('services') }}" class="!py-4.5 !px-10 !rounded-2xl group shadow-lg sm:shrink-0 mb-4 sm:mb-8">
                <span class="flex items-center gap-4 text-xs font-black uppercase tracking-[0.2em]">
                    Katalog Lengkap
                    <i class="ri-arrow-right-line group-hover:translate-x-2 transition-transform"></i>
                </span>
            </x-button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
            @foreach($services as $service)
                <div class="group relative flex flex-col bg-white rounded-[3.5rem] p-10 sm:p-12 border border-gray-100 hover:border-primary/20 transition-all duration-700 h-full hover:-translate-y-3 hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.15)] overflow-hidden">
                    
                    <!-- Decorative Background Fade -->
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        <!-- Upper Icon Part -->
                        <div class="relative mb-12">
                            <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-[2.5rem] bg-{{ $service['color'] }} flex items-center justify-center text-white shadow-3xl shadow-{{ $service['color'] }}/30 group-hover:rotate-[15deg] transition-transform duration-700">
                                @php
                                    $icon = match($service['title']) {
                                        'Saluran Pembuangan' => 'ri-water-flash-fill',
                                        'Air Bersih & Toren' => 'ri-drop-fill',
                                        default => 'ri-tools-fill',
                                    };
                                @endphp
                                <i class="{{ $icon }} text-4xl sm:text-5xl"></i>
                            </div>
                        </div>

                        <!-- Content Part -->
                        <div class="flex-grow">
                            <p class="text-primary font-black text-[10px] sm:text-[11px] uppercase tracking-[0.4em] mb-4">
                                {{ $service['tagline'] }}
                            </p>
                            <h3 class="text-3xl sm:text-4xl font-heading font-black text-secondary mb-6 leading-[1.1] tracking-tighter">
                                {{ $service['title'] }}
                            </h3>
                            <p class="text-gray-400 text-base leading-relaxed font-medium mb-12">
                                {{ $service['desc'] }}
                            </p>
                        </div>

                        <!-- Bottom Action -->
                        <div class="mt-auto">
                            <a href="{{ route('services') }}" class="group/btn inline-flex items-center justify-between w-full py-5 px-8 rounded-2xl bg-stone-50 text-secondary font-black text-xs uppercase tracking-widest hover:bg-secondary hover:text-white transition-all duration-500">
                                <span>Detail & Harga</span>
                                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-secondary group-hover/btn:rotate-[45deg] transition-transform">
                                    <i class="ri-arrow-right-up-line"></i>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Subtle Preview Image -->
                    <div class="absolute -bottom-16 -right-16 w-64 h-64 opacity-0 group-hover:opacity-40 transition-all duration-1000 rotate-12 group-hover:rotate-0 pointer-events-none">
                        <img src="{{ $service['img'] }}" class="w-full h-full object-cover rounded-full" alt="Service Preview">
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Bottom Callout -->
        <div class="mt-24 sm:mt-32 max-w-5xl mx-auto">
             <div class="flex flex-col lg:flex-row items-center justify-between gap-10 p-8 sm:p-6 bg-secondary rounded-[3.5rem] sm:rounded-full shadow-3xl overflow-hidden relative group">
                 <!-- Background Shine -->
                 <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
                 
                 <div class="flex flex-col sm:flex-row items-center gap-8 px-4 relative z-10 text-center sm:text-left">
                    <div class="flex -space-x-4 shrink-0">
                        @for($i=1; $i<=3; $i++)
                            <img src="https://i.pravatar.cc/100?u=tech{{ $i }}" class="w-14 h-14 rounded-full border-4 border-secondary shadow-lg object-cover" alt="Expert">
                        @endfor
                    </div>
                    <div>
                        <p class="text-white font-black text-base sm:text-xl tracking-tight mb-1">
                            Layanan Khusus Gedung & Korporat?
                        </p>
                        <p class="text-primary font-bold text-[10px] sm:text-xs uppercase tracking-[0.2em]">Ekspert kami siap melakukan survey hari ini juga</p>
                    </div>
                 </div>
                 
                 <x-button variant="primary" class="relative group !px-16 !py-6 !rounded-full shadow-2xl shadow-primary/30 w-full sm:w-fit relative z-10" href="https://wa.me/6281234567890">
                    <span class="flex items-center gap-4 font-black uppercase text-xs tracking-widest">
                        Konsultasi Survey
                        <i class="ri-whatsapp-line text-xl transition-transform group-hover:rotate-12"></i>
                    </span>
                 </x-button>
             </div>
        </div>
    </div>
</section>
