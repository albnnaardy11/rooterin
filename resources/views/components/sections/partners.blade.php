@php
    $partners = \App\Models\Partner::where('is_active', true)->orderBy('order')->get();
@endphp

@if($partners->count() > 0)
<section class="py-24 bg-secondary relative overflow-hidden group/section">
    <!-- Premium Dark Decorative Elements -->
    <div class="absolute inset-0 opacity-[0.05] pointer-events-none" style="background-image: linear-gradient(#ffffff 0.5px, transparent 0.5px), linear-gradient(90deg, #ffffff 0.5px, transparent 0.5px); background-size: 60px 60px;"></div>
    
    <!-- Glowing Orbs for Depth -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-accent/10 rounded-full blur-[120px] pointer-events-none"></div>
    
    <!-- Subtle Gradient Overlays -->
    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-black/20 to-transparent"></div>
    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black/20 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <!-- Header -->
        <div class="flex flex-col items-center text-center mb-16 px-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-primary text-[10px] font-bold uppercase tracking-[0.3em] mb-6 animate-fade-in-up">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                </span>
                The Professional Choice
            </div>
            
            <h2 class="text-4xl md:text-5xl font-heading font-black text-white mb-8 tracking-tighter leading-tight animate-fade-in-up" style="animation-delay: 100ms">
                Kemitraan <span class="relative inline-block">
                    <span class="relative z-10 italic text-primary">Strategis.</span>
                    <span class="absolute -bottom-1 left-0 w-full h-3 bg-primary/20 -rotate-1 rounded"></span>
                </span>
            </h2>
            
            <p class="text-gray-400 font-medium max-w-2xl text-lg leading-relaxed animate-fade-in-up" style="animation-delay: 200ms">
                Menjamin kontinuitas operasional di berbagai sektor industri papan atas. Dedikasi kami adalah fondasi bagi kepercayaan global mereka.
            </p>
        </div>

        <!-- Superior Infinite Logo Slider -->
        <div class="relative mt-20 group/marquee">
            <!-- Premium Glassmorphism Container (Dark) -->
            <div class="relative bg-white/5 backdrop-blur-md rounded-[2.5rem] border border-white/10 p-2 sm:p-6 overflow-hidden shadow-2xl shadow-black/50">
                <!-- Overlay Gradient Masks -->
                <div class="absolute inset-y-0 left-0 w-24 sm:w-48 bg-gradient-to-r from-secondary to-transparent z-20 pointer-events-none"></div>
                <div class="absolute inset-y-0 right-0 w-24 sm:w-48 bg-gradient-to-l from-secondary to-transparent z-20 pointer-events-none"></div>

                <div class="flex overflow-hidden">
                    <div class="flex animate-marquee-premium py-8 items-center group-hover/marquee:pause-marquee group-active/marquee:pause-marquee">
                        @php 
                            $loopPartners = $partners->concat($partners)->concat($partners)->concat($partners);
                        @endphp
                        @foreach($loopPartners as $partner)
                        <div class="flex-shrink-0 mx-6 sm:mx-10 group/logo">
                            <div class="flex items-center justify-center p-3 sm:p-4 rounded-xl sm:rounded-2xl transition-all duration-300 transform-gpu
                                        bg-white/10 sm:bg-white/5 
                                        active:bg-white active:scale-110 active:shadow-2xl active:shadow-primary/30
                                        hover:bg-white hover:scale-110 hover:shadow-2xl hover:shadow-primary/20
                                        backdrop-blur-sm border border-white/10 hover:border-white active:border-white">
                                <img src="{{ asset($partner->logo_path) }}" 
                                     alt="{{ $partner->name }}" 
                                     class="h-7 sm:h-12 w-auto max-w-[100px] sm:max-w-[160px] object-contain transition-all duration-300
                                            filter grayscale brightness-150 sm:brightness-125 opacity-70 sm:opacity-50
                                            group-active/logo:grayscale-0 group-active/logo:brightness-100 group-active/logo:opacity-100
                                            group-hover/logo:grayscale-0 group-hover/logo:brightness-100 group-hover/logo:opacity-100"
                                     title="{{ $partner->name }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Contextual Stats Grid (Enhanced with Cards) -->
            <div class="mt-24 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <div class="group/stat px-8 py-10 rounded-[2rem] bg-white/5 border border-white/10 flex flex-col items-center text-center transition-all duration-500 hover:bg-white/10 hover:-translate-y-2 hover:border-primary/30">
                    <div class="text-5xl font-heading font-black text-white mb-3 group-hover/stat:text-primary transition-colors duration-300">50+</div>
                    <div class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">Mitra Korporat</div>
                </div>
                
                <div class="group/stat px-8 py-10 rounded-[2rem] bg-white/5 border border-white/10 flex flex-col items-center text-center transition-all duration-500 hover:bg-white/10 hover:-translate-y-2 hover:border-primary/30">
                    <div class="text-5xl font-heading font-black text-primary mb-3 group-hover/stat:text-white transition-colors duration-300">99%</div>
                    <div class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">SLA Response</div>
                </div>
                
                <div class="group/stat px-8 py-10 rounded-[2rem] bg-white/5 border border-white/10 flex flex-col items-center text-center transition-all duration-500 hover:bg-white/10 hover:-translate-y-2 hover:border-accent/30">
                    <div class="text-5xl font-heading font-black text-white mb-3 group-hover/stat:text-accent transition-colors duration-300">24h</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Kesiapan Tim</div>
                </div>
                
                <div class="group/stat px-8 py-10 rounded-[2rem] bg-white/5 border border-white/10 flex flex-col items-center text-center transition-all duration-500 hover:bg-white/10 hover:-translate-y-2 hover:border-primary/30">
                    <div class="text-5xl font-heading font-black text-accent mb-3 group-hover/stat:text-primary transition-colors duration-300">1+</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Dekade Industri</div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes marquee-premium {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee-premium {
        animation: marquee-premium 60s linear infinite;
    }
    .pause-marquee {
        animation-play-state: paused;
    }
</style>
@endif
