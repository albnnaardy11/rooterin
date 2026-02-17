<section class="py-32 bg-stone-50 relative overflow-hidden" x-data="{ 
    filter: 'All',
    items: {{ json_encode($items) }},
    activeItem: null,
    get filteredItems() {
        if (this.filter === 'All') return this.items;
        return this.items.filter(i => i.category === this.filter);
    }
}">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-[50%] h-[50%] bg-white rounded-full blur-[150px] -translate-y-1/2 translate-x-1/2"></div>
    
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-12 mb-20">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-4 mb-6">
                    <span class="w-12 h-[2px] bg-primary"></span>
                    <span class="text-primary font-black text-xs uppercase tracking-[0.4em]">Dokumentasi Lapangan</span>
                </div>
                <h2 class="text-5xl sm:text-7xl font-heading font-black text-secondary leading-none tracking-tighter">
                    Galeri Hasil <br> <span class="text-primary italic">Kerja Nyata.</span>
                </h2>
            </div>

            <!-- Custom Filter Tabs -->
            <div class="flex flex-wrap items-center gap-3 bg-white p-3 rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100">
                <template x-for="cat in ['All', 'Residential', 'Commercial', 'Specialized']">
                    <button 
                        @click="filter = cat"
                        :class="filter === cat ? 'bg-secondary text-white shadow-lg' : 'text-gray-400 hover:text-secondary hover:bg-stone-50'"
                        class="px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-500"
                        x-text="cat">
                    </button>
                </template>
            </div>
        </div>

        <!-- Bento-Style Dense Grid (Fixed Gaps) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 grid-flow-dense gap-6 lg:gap-8">
            <template x-for="(item, index) in filteredItems" :key="index">
                <div 
                    x-show="true"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    @click="activeItem = item"
                    class="group relative cursor-pointer"
                    :class="{ 
                        'lg:col-span-2 lg:row-span-2': index % 10 === 0, 
                        'lg:col-span-2': index % 10 === 3 || index % 10 === 7,
                        'lg:row-span-2': index % 10 === 5
                    }">
                    
                    <div class="relative w-full h-full min-h-[300px] lg:min-h-0 rounded-[2.5rem] overflow-hidden bg-secondary shadow-2xl transition-all duration-700 group-hover:-translate-y-4">
                        <!-- Main Image -->
                        <img :src="item.img" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                        
                        <!-- Premium Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary via-secondary/20 to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>
                        
                        <!-- Content Overlay -->
                        <div class="absolute inset-0 p-10 flex flex-col justify-end translate-y-6 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="flex items-center gap-3 mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                                <span class="px-4 py-1.5 rounded-full bg-primary text-white text-[9px] font-black uppercase tracking-widest" x-text="item.category"></span>
                                <div class="w-10 h-[1px] bg-white/30"></div>
                            </div>
                            <h3 class="text-white text-2xl font-heading font-black leading-tight tracking-tight mb-2 group-hover:text-primary transition-colors" x-text="item.title"></h3>
                            <div class="flex items-center gap-2 overflow-hidden max-h-0 group-hover:max-h-20 transition-all duration-700">
                                <p class="text-gray-400 text-xs font-medium italic">Lihat detail pengerjaan</p>
                                <i class="ri-arrow-right-line text-primary"></i>
                            </div>
                        </div>

                        <!-- Scanline Effect -->
                        <div class="absolute inset-x-0 top-0 h-[1px] bg-white/20 -translate-y-full group-hover:translate-y-[500%] transition-all duration-[3000ms] ease-linear"></div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State -->
        <div x-show="filteredItems.length === 0" class="py-40 text-center">
            <i class="ri-search-eye-line text-8xl text-gray-200 mb-8 block"></i>
            <h3 class="text-2xl font-heading font-black text-secondary tracking-tight">Tidak ada dokumentasi ditemukan.</h3>
            <p class="text-gray-400 mt-2">Coba pilih kategori dokumentasi lapangan lainnya.</p>
        </div>
    </div>

    <!-- Immersive Modal Lightbox -->
    <template x-teleport="body">
        <div x-show="activeItem" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-10"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div @click="activeItem = null" class="absolute inset-0 bg-secondary/95 backdrop-blur-3xl"></div>
            
            <div class="max-w-6xl w-full bg-white rounded-[4rem] overflow-hidden shadow-[0_50px_100px_rgba(0,0,0,0.5)] relative z-10 flex flex-col lg:flex-row h-full max-h-[90vh]">
                <!-- Large Image Area -->
                <div class="lg:w-8/12 bg-black flex items-center justify-center overflow-hidden">
                    <img :src="activeItem?.img" class="w-full h-full object-cover">
                </div>
                
                <!-- Info Area -->
                <div class="lg:w-4/12 p-12 lg:p-16 flex flex-col justify-between">
                    <div>
                        <button @click="activeItem = null" class="w-14 h-14 rounded-full bg-stone-50 flex items-center justify-center text-secondary hover:bg-primary hover:text-white transition-all mb-12">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                        
                        <div class="inline-block px-4 py-1.5 rounded-full bg-stone-100 text-gray-500 text-[10px] font-black uppercase tracking-[0.2em] mb-6" x-text="activeItem?.category"></div>
                        <h2 class="text-4xl font-heading font-black text-secondary leading-tight tracking-tighter mb-8" x-text="activeItem?.title"></h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                    <i class="ri-checkbox-circle-fill"></i>
                                </div>
                                <p class="text-gray-500 text-sm leading-relaxed">Pengerjaan menggunakan metode modern tanpa merusak struktur pipa bangunan.</p>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-accent/10 flex items-center justify-center text-accent shrink-0">
                                    <i class="ri-shield-check-fill"></i>
                                </div>
                                <p class="text-gray-500 text-sm leading-relaxed">Garansi pelancaran kembali jika mampet dalam masa waktu yang ditentukan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-12 border-t border-gray-100">
                        <a href="https://wa.me/6281234567890" class="w-full flex items-center justify-center gap-4 bg-secondary py-5 rounded-2xl text-white font-black uppercase tracking-widest text-xs hover:bg-primary transition-all group">
                             <i class="ri-whatsapp-line text-xl"></i>
                             <span>Konsultasi Serupa</span>
                             <i class="ri-arrow-right-line group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </template>
</section>
