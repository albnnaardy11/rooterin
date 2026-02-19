<section x-data="{ 
    activeCategory: null,
    categories: [
        {
            id: 'A',
            title: 'Saluran Pembuangan Mampet',
            icon: 'ri-water-flash-fill',
            color: 'primary',
            items: [
                'Sal. Kamar Mandi', 'Sal. Cuci Piring', 'Sal. Cuci Tangan', 
                'Sal. Talang Air Hujan', 'Sal. Urinoir', 'Sal. Kloset', 
                'Sal. Bak Kontrol', 'Lain-lain'
            ],
            pricing: [
                { type: 'Rumah Hunian', price: 'Rp. 600.000,-', note: 'Per-titik Masalah, Garansi 30 Hari' },
                { type: 'Komersial (Resto, Kantor, dll)', price: 'Rp. 800.000 - 1.800.000', note: 'Per-titik Masalah, Garansi 30 Hari' }
            ]
        },
        {
            id: 'B',
            title: 'Air Bersih & Cuci Toren',
            icon: 'ri-drop-fill',
            color: 'accent',
            items: [
                'Kran Mampet', 'Cuci Toren / Tangki Air'
            ],
            pricing: [
                { type: 'Survey Lokasi', price: 'Gratis', note: 'Biaya ditentukan setelah survey lokasi' }
            ]
        },
        {
            id: 'C',
            title: 'Instalasi Sanitary & Pipa',
            icon: 'ri-tools-fill',
            color: 'secondary',
            items: [
                'Instalasi Pipa Air Bersih', 'Instalasi Pipa Air Kotor', 
                'Instalasi Kloset Jongkok/Duduk', 'Instalasi Sanitary', 
                'Instalasi Kran Air', 'Lain-lain'
            ],
            pricing: [
                { type: 'Project Based', price: 'Custom Quote', note: 'Berdasarkan volume pengerjaan & material' }
            ]
        }
    ]
}" class="py-32 bg-white relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute top-1/2 left-0 w-72 h-72 bg-primary/5 rounded-full blur-3xl -translate-x-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent/5 rounded-full blur-3xl translate-x-1/3"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="mb-24 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-4 mb-6">
                    <span class="w-12 h-[2px] bg-primary"></span>
                    <span class="text-primary font-black text-xs uppercase tracking-[0.4em]">Katalog Layanan</span>
                </div>
                <h2 class="text-4xl sm:text-6xl font-heading font-black text-secondary leading-tight tracking-tighter">
                    Solusi <span class="text-primary italic">Plumbing Digital.</span>
                </h2>
                <p class="text-gray-400 mt-6 text-lg font-medium leading-relaxed">
                    Kami membagi keahlian kami dalam 3 kategori utama guna memastikan Anda mendapatkan penanganan yang spesifik dan akurat.
                </p>
            </div>
        </div>

        <!-- Service Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <template x-for="cat in categories" :key="cat.id">
                <div 
                    @click="activeCategory = cat"
                    class="group relative bg-stone-50 rounded-[3rem] p-8 sm:p-10 border border-gray-100 hover:border-primary/30 hover:bg-white hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 cursor-pointer overflow-hidden flex flex-col h-full"
                >
                    <!-- Floating Icon Decor -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-gray-100/50 rounded-full group-hover:bg-primary/5 group-hover:scale-150 transition-all duration-700"></div>

                    <div class="relative z-10 flex flex-col h-full">
                        <div 
                            :class="{
                                'bg-primary shadow-primary/20': cat.color === 'primary',
                                'bg-accent shadow-accent/20': cat.color === 'accent',
                                'bg-secondary shadow-secondary/20': cat.color === 'secondary'
                            }"
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-[2rem] flex items-center justify-center text-white mb-8 sm:mb-10 shadow-2xl group-hover:rotate-12 transition-transform duration-500"
                        >
                            <i :class="cat.icon" class="text-3xl sm:text-4xl"></i>
                        </div>

                        <h3 class="text-2xl sm:text-3xl font-heading font-black text-secondary mb-6 leading-tight" x-text="cat.title"></h3>
                        
                        <div class="space-y-3 mb-12 flex-grow">
                            <template x-for="(item, index) in cat.items.slice(0, 3)" :key="index">
                                <div class="flex items-center gap-3 text-gray-400">
                                    <div class="w-1.5 h-1.5 rounded-full bg-primary/40"></div>
                                    <span class="text-[10px] sm:text-xs font-bold uppercase tracking-widest" x-text="item"></span>
                                </div>
                            </template>
                            <div x-show="cat.items.length > 3" class="text-primary font-black text-[10px] uppercase tracking-[0.2em] mt-4 flex items-center gap-2">
                                <span x-text="`+ ${cat.items.length - 3} Lainnya`"></span>
                                <i class="ri-arrow-right-line"></i>
                            </div>
                        </div>

                        <button class="w-full py-5 rounded-2xl bg-secondary text-white font-black uppercase text-[10px] tracking-widest group-hover:bg-primary transition-colors mt-auto">
                            Cek Detail & Harga
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Professional Equipment Mini-Banner -->
        <div class="mt-24 p-8 sm:p-16 bg-secondary rounded-[4rem] relative overflow-hidden shadow-3xl">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="flex items-center gap-4 mb-8">
                        <span class="w-10 h-[2px] bg-primary"></span>
                        <span class="text-primary font-black text-xs uppercase tracking-[0.4em]">Professional Toolkit</span>
                    </div>
                    <h3 class="text-3xl sm:text-5xl font-heading font-black text-white leading-tight mb-8">
                        Teknologi Yang Kami <span class="text-primary italic">Gunakan.</span>
                    </h3>
                    <div class="space-y-6">
                        <div class="flex items-start gap-6">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-primary shrink-0">
                                <i class="ri-refresh-line text-3xl animate-spin-slow"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-black text-lg mb-1">Drain Cleaner Spiral Baja</h4>
                                <p class="text-gray-400 text-sm leading-relaxed">Spiral elastis jangkauan 20-30m yang mampu menghancurkan hambatan pipa mengikuti kelokan jalur.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-6">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-accent shrink-0">
                                <i class="ri-water-flash-fill text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-black text-lg mb-1">High Pressure Submersible</h4>
                                <p class="text-gray-400 text-sm leading-relaxed">Pompa tekanan tinggi 200 Liter/Menit untuk membilas sisa kotoran yang telah dihancurkan mesin spiral.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Visual Placeholder/Image -->
                <div class="relative aspect-video rounded-[3rem] overflow-hidden group border-4 border-white/5 shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=1200" class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700" alt="Plumbing Machine">
                    <div class="absolute inset-x-8 bottom-8 p-6 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl">
                        <p class="text-white font-black text-[10px] uppercase tracking-[0.3em] text-center">Equipment Standard Internasional</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Immersive Service Modal -->
    <template x-teleport="body">
        <div x-show="activeCategory" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-10"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @keydown.escape.window="activeCategory = null"
             style="display: none;">
            
            <div @click="activeCategory = null" class="absolute inset-0 bg-secondary/95 backdrop-blur-2xl"></div>
            
            <div class="w-full max-w-5xl bg-white rounded-[2.5rem] sm:rounded-[4rem] shadow-2xl relative z-10 flex flex-col lg:flex-row h-auto max-h-[92vh] overflow-y-auto lg:overflow-hidden no-scrollbar">
                
                <!-- Close Button (Sticky on Mobile) -->
                <div class="sticky lg:absolute top-0 right-0 z-50 p-4 lg:p-6 bg-white/80 lg:bg-transparent backdrop-blur-md lg:backdrop-blur-none flex justify-end w-full lg:w-auto">
                    <button @click="activeCategory = null" 
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-secondary text-white lg:bg-secondary/10 lg:text-secondary flex items-center justify-center hover:bg-primary transition-all shadow-xl group">
                        <i class="ri-close-line text-xl sm:text-2xl group-hover:rotate-90 transition-transform duration-500"></i>
                    </button>
                </div>

                <!-- Left: Info & Items -->
                <div class="w-full lg:w-1/2 p-5 sm:p-10 lg:p-16 lg:overflow-y-auto no-scrollbar">
                    <div class="inline-flex items-center gap-3 px-3 py-1.5 rounded-full bg-stone-100 text-gray-500 font-bold text-[9px] sm:text-[10px] uppercase tracking-widest mb-6 sm:mb-8">
                        Detail Layanan
                    </div>
                    
                    <h2 class="text-2xl sm:text-4xl font-heading font-black text-secondary leading-tight tracking-tighter mb-6 sm:mb-10" x-text="activeCategory?.title"></h2>
                    
                    <div class="space-y-4">
                        <p class="text-gray-400 font-black text-[9px] uppercase tracking-[0.3em] mb-4">Cakupan Pekerjaan:</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-3 sm:gap-4">
                            <template x-for="(item, index) in activeCategory?.items" :key="index">
                                <div class="flex items-center gap-3 p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-stone-50 border border-gray-100 hover:border-primary/20 transition-colors">
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                        <i class="ri-check-line text-base sm:text-lg"></i>
                                    </div>
                                    <span class="text-secondary font-bold text-[9px] sm:text-xs uppercase tracking-tight" x-text="item"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Policy Notes -->
                    <div class="mt-8 sm:mt-12 p-5 sm:p-8 bg-primary/5 rounded-[1.5rem] sm:rounded-[2rem] border border-primary/10">
                        <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-4">
                            <i class="ri-error-warning-fill text-primary text-lg sm:text-2xl"></i>
                            <h5 class="text-secondary font-black text-[10px] sm:text-xs uppercase tracking-widest">Penting Untuk Diketahui</h5>
                        </div>
                        <ul class="space-y-2 sm:space-y-3">
                            <li class="flex gap-2 sm:gap-3 items-start">
                                <div class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></div>
                                <p class="text-gray-500 text-[10px] sm:text-[11px] leading-relaxed">Jika gagal karena masalah tidak ditemukan, biaya <span class="text-primary font-bold">GRATIS.</span></p>
                            </li>
                            <li class="flex gap-2 sm:gap-3 items-start">
                                <div class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></div>
                                <p class="text-gray-500 text-[10px] sm:text-[11px] leading-relaxed">Jika masalah utama (septictank penuh), biaya tetap sesuai kontrak.</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right: Pricing & CTA -->
                <div class="w-full lg:w-1/2 bg-stone-50 p-5 sm:p-10 lg:p-16 flex flex-col justify-between border-t lg:border-t-0 lg:border-l border-gray-100 lg:overflow-y-auto no-scrollbar">
                    <div>
                        <div class="flex items-center gap-3 sm:gap-4 mb-6 sm:mb-10">
                            <span class="w-6 sm:w-10 h-[2px] bg-accent"></span>
                            <span class="text-accent font-black text-[9px] sm:text-xs uppercase tracking-[0.4em]">Estimasi Biaya</span>
                        </div>

                        <div class="space-y-4 sm:space-y-6">
                            <template x-for="(p, index) in activeCategory?.pricing" :key="index">
                                <div class="p-5 sm:p-8 bg-white rounded-2xl sm:rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                                    <h4 class="text-gray-400 font-bold text-[8px] sm:text-[10px] uppercase tracking-widest mb-1 sm:mb-2" x-text="p.type"></h4>
                                    <div class="flex items-baseline gap-2 mb-1">
                                        <span class="text-lg sm:text-3xl font-heading font-black text-secondary" x-text="p.price"></span>
                                    </div>
                                    <p class="text-primary font-bold text-[8px] sm:text-[10px] uppercase tracking-widest" x-text="p.note"></p>
                                </div>
                            </template>
                        </div>

                        <!-- Special Survey Notice -->
                        <div class="mt-6 sm:mt-8 flex items-center gap-3 sm:gap-4 px-4 sm:px-6 py-3 rounded-xl sm:rounded-2xl bg-white border border-dashed border-gray-200">
                            <i class="ri-survey-line text-accent text-lg sm:text-xl"></i>
                            <p class="text-gray-500 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest leading-relaxed">Gedung / Ruko: Biaya ditentukan setelah Survey Lokasi.</p>
                        </div>
                    </div>

                    <div class="mt-8 sm:mt-12 space-y-3 sm:space-y-4 text-center lg:text-left">
                        <a href="https://wa.me/6281234567890" class="w-full flex items-center justify-center gap-3 bg-secondary py-4 sm:py-6 rounded-xl sm:rounded-2xl text-white font-black uppercase tracking-widest text-[10px] sm:text-xs hover:bg-primary transition-all duration-300 shadow-xl">
                            <i class="ri-whatsapp-line text-lg sm:text-xl"></i>
                            <span>Pesan Layanan Sekarang</span>
                        </a>
                        <p class="text-[8px] sm:text-[9px] text-gray-400 font-bold uppercase tracking-widest italic opacity-60">Teknisi berangkat dalam 45 menit ke lokasi</p>
                    </div>
                </div>

            </div>
        </div>
    </template>

</section>
