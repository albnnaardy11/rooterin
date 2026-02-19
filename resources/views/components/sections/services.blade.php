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
        
        <!-- Bottom Callout - Premium Corporate Banner -->
        <div class="mt-24 sm:mt-32 max-w-6xl mx-auto">
             <div class="flex flex-col lg:flex-row items-center justify-between gap-10 p-4 sm:p-5 lg:p-6 bg-secondary rounded-[3rem] lg:rounded-full shadow-3xl shadow-secondary/20 overflow-hidden relative group border border-white/5">
                 <!-- Modern Animated Background -->
                 <div class="absolute inset-0 bg-gradient-to-r from-secondary via-primary/5 to-secondary group-hover:via-primary/10 transition-colors duration-1000"></div>
                 <div class="absolute -top-1/2 -right-1/4 w-[50%] h-[200%] bg-primary/10 blur-[100px] rotate-45 pointer-events-none group-hover:translate-x-12 transition-transform duration-[3s]"></div>
                 
                 <div class="flex flex-col sm:flex-row items-center gap-10 px-6 relative z-10 text-center sm:text-left w-full lg:w-auto">
                    <!-- Experts Stack with Online Indicator -->
                    <div class="relative shrink-0">
                        <div class="flex -space-x-5">
                            @for($i=1; $i<=3; $i++)
                                <div class="relative group/avatar">
                                    <div class="absolute -inset-1 bg-gradient-to-tr from-primary to-accent rounded-full opacity-40 group-hover/avatar:opacity-100 blur-sm transition-opacity duration-500"></div>
                                    <img src="https://i.pravatar.cc/100?u=tech{{ $i }}" class="relative w-16 h-16 rounded-full border-[6px] border-secondary shadow-2xl object-cover transition-transform duration-500 group-hover/avatar:scale-110" alt="Expert">
                                </div>
                            @endfor
                        </div>
                        <!-- Pulse Indicator -->
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-primary rounded-full border-[4px] border-secondary flex items-center justify-center">
                            <span class="absolute w-full h-full bg-primary rounded-full animate-ping opacity-75"></span>
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-white font-black text-2xl lg:text-3xl tracking-tight leading-none">
                            Layanan Khusus <span class="text-primary italic">Gedung & Korporat?</span>
                        </h4>
                        <div class="flex items-center justify-center sm:justify-start gap-4">
                            <span class="w-8 h-[2px] bg-primary/40 hidden sm:block"></span>
                            <p class="text-gray-400 font-bold text-[10px] sm:text-xs uppercase tracking-[0.3em]">Technical Experts Ready for Survey Today</p>
                        </div>
                    </div>
                 </div>
                 
                 <!-- Premium WhatsApp CTA -->
                 <div class="w-full lg:w-auto px-4 sm:px-0 relative z-10">
                    <x-button variant="primary" class="relative group/btn !px-14 !py-7 !rounded-full shadow-2xl shadow-primary/40 w-full sm:w-fit overflow-hidden" href="https://wa.me/6281234567890">
                        <span class="relative z-10 flex items-center justify-center gap-5 text-white">
                            <div class="relative">
                                <i class="ri-whatsapp-line text-2xl animate-bounce-soft"></i>
                                <div class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-white rounded-full border-2 border-primary animate-pulse"></div>
                            </div>
                            <span class="font-black uppercase text-sm tracking-[0.2em]">Konsultasi Survey</span>
                            <i class="ri-arrow-right-line transition-transform duration-500 group-hover/btn:translate-x-3 text-xl"></i>
                        </span>

                        <!-- Premium Shine Animation -->
                        <div class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/30 to-transparent skew-x-[45deg] group-hover/btn:left-[150%] transition-all duration-1000 ease-in-out"></div>
                    </x-button>
                 </div>
             </div>
        </div>
    </div>
</section>
