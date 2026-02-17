<section class="py-32 bg-white relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-1/2 left-0 w-72 h-72 bg-primary/5 rounded-full blur-3xl -translate-x-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent/5 rounded-full blur-3xl translate-x-1/3"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="mb-24">
            <div class="inline-flex items-center gap-4 mb-6">
                <span class="w-12 h-[2px] bg-primary"></span>
                <span class="text-primary font-black text-xs uppercase tracking-[0.4em]">Solusi Terpadu</span>
            </div>
            <h2 class="text-4xl sm:text-6xl font-heading font-black text-secondary leading-tight tracking-tighter">
                Layanan <span class="text-primary italic">Kami.</span>
            </h2>
        </div>

        <!-- Service Matrix Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
            
            <!-- Category 1: Pelancar & Pembersihan -->
            <div class="group">
                <div class="flex items-center gap-6 mb-12">
                    <div class="w-20 h-20 bg-primary rounded-[2rem] flex items-center justify-center text-white shadow-2xl shadow-primary/20 transition-transform group-hover:rotate-6 duration-500">
                        <i class="ri-water-flash-fill text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-heading font-black text-secondary uppercase tracking-tighter">Pelancar & Pembersihan</h3>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Saluran & Pipa Mampet</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    @foreach([
                        ['label' => 'WC Mampet', 'icon' => 'ri-drop-line', 'desc' => 'Pelancaran kloset tersumbat tanpa bongkar.'],
                        ['label' => 'Wastafel Mampet', 'icon' => 'ri-hand-heart-line', 'desc' => 'Pembersihan pipa pembuangan cuci tangan.'],
                        ['label' => 'Floor Drain Mampet', 'icon' => 'ri-grid-fill', 'desc' => 'Solusi genangan air di lantai kamar mandi.'],
                        ['label' => 'Saluran Dapur Berminyak', 'icon' => 'ri-cup-line', 'desc' => 'Pembersihan kerak lemak membandel.'],
                        ['label' => 'Got & Drainase Tersumbat', 'icon' => 'ri-heavy-showers-line', 'desc' => 'Normalisasi saluran air pembuangan luar.']
                    ] as $item)
                        <div class="relative p-8 bg-primary rounded-[2.5rem] overflow-hidden group/item hover:-translate-y-2 transition-transform duration-500">
                            <!-- Background Decor -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover/item:scale-150 transition-transform duration-700"></div>
                            
                            <div class="relative z-10 flex items-center gap-6">
                                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-white group-hover/item:bg-white group-hover/item:text-primary transition-all">
                                    <i class="{{ $item['icon'] }} text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-white font-black text-xl mb-1">{{ $item['label'] }}</h4>
                                    <p class="text-white/80 text-xs font-medium">{{ $item['desc'] }}</p>
                                </div>
                                <i class="ri-arrow-right-up-line text-white/30 group-hover/item:text-white text-2xl transition-colors"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Category 2: Instalasi & Perbaikan -->
            <div class="group">
                <div class="flex items-center gap-6 mb-12">
                    <div class="w-20 h-20 bg-secondary rounded-[2rem] flex items-center justify-center text-white shadow-2xl transition-transform group-hover:-rotate-6 duration-500">
                        <i class="ri-tools-fill text-4xl text-primary"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-heading font-black text-secondary uppercase tracking-tighter">Instalasi & Perbaikan</h3>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Teknik & Perpipaan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    @foreach([
                        ['label' => 'Instalasi Pipa Air', 'icon' => 'ri-ruler-2-line', 'desc' => 'Pemasangan jalur air bersih & kotor baru.'],
                        ['label' => 'Perbaikan Kebocoran', 'icon' => 'ri-drop-line', 'desc' => 'Penanganan pipa bocor dalam tembok/lantai.'],
                        ['label' => 'Perawatan Berkala', 'icon' => 'ri-calendar-check-line', 'desc' => 'Maintenance rutin saluran gedung & resto.'],
                        ['label' => 'Preventive Maintenance', 'icon' => 'ri-shield-flash-line', 'desc' => 'Pencegahan mampet sebelum masalah datang.']
                    ] as $item)
                        <div class="relative p-8 bg-secondary rounded-[2.5rem] overflow-hidden group/item hover:-translate-y-2 transition-transform duration-500">
                            <!-- Background Decor -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover/item:scale-150 transition-transform duration-700"></div>
                            
                            <div class="relative z-10 flex items-center gap-6">
                                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-accent group-hover/item:bg-accent group-hover/item:text-white transition-all">
                                    <i class="{{ $item['icon'] }} text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-white font-black text-xl mb-1">{{ $item['label'] }}</h4>
                                    <p class="text-gray-400 text-xs font-medium">{{ $item['desc'] }}</p>
                                </div>
                                <i class="ri-arrow-right-up-line text-white/20 group-hover/item:text-accent text-2xl transition-colors"></i>
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Callout Info -->
                    <div class="mt-4 p-8 bg-accent/10 border-2 border-dashed border-accent/20 rounded-[2.5rem] flex items-center gap-6">
                        <div class="w-14 h-14 shrink-0 bg-accent text-white rounded-full flex items-center justify-center shadow-lg shadow-accent/20 animate-bounce-soft">
                            <i class="ri-information-fill text-3xl"></i>
                        </div>
                        <p class="text-secondary font-black text-sm italic leading-relaxed">
                            Teknisi kami dilengkapi kamera inspeksi <span class="text-accent underline decoration-2 underline-offset-4">(Endoscope)</span> untuk memastikan pengerjaan tepat sasaran.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
