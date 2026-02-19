@props([
    'title' => 'Pilih Layanan Yang Anda Butuhkan',
    'subtitle' => 'SOLUSI TERLENGKAP',
    'services' => []
])

<section id="services" {{ $attributes->merge(['class' => 'py-16 sm:py-32 bg-stone-50 relative overflow-hidden']) }}>
    <!-- Background Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <x-section-heading :title="$title" :subtitle="$subtitle" />
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-12 mt-16">
            @foreach($services as $service)
                <x-service-card 
                    :title="$service['title']"
                    :desc="$service['desc']"
                    :img="$service['img']"
                    :color="$service['color']"
                />
            @endforeach
        </div>
        
        <!-- Bottom Callout - Responsive Optimized -->
        <div class="mt-20 sm:mt-32 max-w-4xl mx-auto">
             <div class="flex flex-col lg:flex-row items-center justify-between gap-8 p-6 sm:p-4 bg-white rounded-[2rem] sm:rounded-full shadow-2xl shadow-gray-200/50 border border-gray-100/50">
                 <div class="flex flex-col sm:flex-row items-center gap-6 px-4">
                    <div class="flex -space-x-4">
                        @for($i=1; $i<=3; $i++)
                            <img src="https://i.pravatar.cc/100?u=tech{{ $i }}" class="w-12 h-12 rounded-full border-4 border-white shadow-sm object-cover" alt="Expert">
                        @endfor
                    </div>
                    <div class="text-center sm:text-left">
                        <p class="text-secondary font-black text-sm sm:text-base tracking-tight">
                            Masalah pipa lainnya? <span class="text-primary">Teknisi kami siap memberikan survey gratis.</span>
                        </p>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Available 24/7 for emergency cases</p>
                    </div>
                 </div>
                 <x-button variant="primary" class="relative group !px-12 !py-4.5 !rounded-full shadow-2xl shadow-primary/20 w-fit lg:w-auto overflow-hidden whitespace-nowrap" href="https://wa.me/6281234567890">
                    <span class="relative z-10 flex items-center gap-3 font-black uppercase text-[11px] tracking-[0.2em]">
                        Hubungi CS!
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center transition-transform group-hover:rotate-12">
                            <i class="ri-customer-service-2-fill text-lg"></i>
                        </div>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
                 </x-button>
             </div>
        </div>
    </div>
</section>
