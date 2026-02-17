<section class="py-32 bg-secondary relative overflow-hidden">
    <!-- 1. Cinematic Background Decor -->
    <div class="absolute inset-0 z-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
    <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-[20%] -right-[10%] w-[60%] h-[60%] bg-accent/10 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header: Centered & High Impact -->
        <div class="text-center mb-24">
            <div class="inline-flex items-center gap-4 mb-6 px-6 py-2 rounded-full border border-primary/30 bg-primary/5">
                <i class="ri-flask-fill text-primary"></i>
                <span class="text-primary font-black text-xs uppercase tracking-[0.5em]">Metode & Teknologi</span>
            </div>
            <h2 class="text-5xl sm:text-7xl font-heading font-black text-white leading-tight tracking-tighter">
                Sains Dibalik <span class="text-primary italic">Solusi Kami.</span>
            </h2>
            <p class="text-gray-400 mt-6 max-w-2xl mx-auto font-medium text-lg leading-relaxed">
                Kami menggabungkan keahlian teknis bertahun-tahun dengan peralatan mutakhir untuk memastikan saluran Anda kembali normal tanpa merusak properti.
            </p>
        </div>

        <!-- The "Process Lab" Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- A. Left Column: The 4 Core Techniques (Interactive Sidebar) -->
            <div class="lg:col-span-5 space-y-6">
                <h4 class="text-white/40 font-black text-xs uppercase tracking-[0.4em] mb-10 flex items-center gap-4">
                    The Toolkit
                    <span class="flex-grow h-[1px] bg-white/10"></span>
                </h4>

                @foreach([
                    ['icon' => 'ri-cpu-line', 'title' => 'Mesin Rooter / Auger', 'desc' => 'Pembersihan pipa mekanik presisi tinggi tanpa perlu pembongkaran.', 'color' => 'primary'],
                    ['icon' => 'ri-water-flash-line', 'title' => 'Jetting High Pressure', 'desc' => 'Sistem semprotan air 3000 PSI untuk menghancurkan kerak lemak.', 'color' => 'accent'],
                    ['icon' => 'ri-guide-line', 'title' => 'Spiral Manual Teknis', 'desc' => 'Akurasi pembersihan maksimal untuk sudut pipa yang sulit dijangkau.', 'color' => 'primary text-opacity-50'],
                    ['icon' => 'ri-eye-line', 'title' => 'Kamera Inspeksi Pipa', 'desc' => 'Visualisasi real-time dalam pipa untuk hasil kerja yang transparan.', 'color' => 'accent text-opacity-50']
                ] as $tech)
                    <div class="group relative p-8 rounded-[2.5rem] bg-white/5 border border-white/10 hover:bg-white/10 hover:border-primary/30 transition-all duration-500 cursor-default">
                        <!-- Glow Effect on Hover -->
                        <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 blur-2xl transition-opacity"></div>
                        
                        <div class="relative z-10 flex items-start gap-6">
                            <div class="w-16 h-16 rounded-2xl bg-secondary border border-white/10 flex items-center justify-center text-{{ $tech['color'] }} group-hover:scale-110 transition-transform shadow-2xl">
                                <i class="{{ $tech['icon'] }} text-3xl"></i>
                            </div>
                            <div>
                                <h5 class="text-white font-black text-lg mb-2 group-hover:text-primary transition-colors">{{ $tech['title'] }}</h5>
                                <p class="text-gray-400 text-xs font-medium leading-relaxed">{{ $tech['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- B. Right Column: The "Master View" (Large Image & Benefits) -->
            <div class="lg:col-span-7 sticky top-32">
                <div class="relative rounded-[4rem] overflow-hidden group shadow-2xl border-4 border-white/5 aspect-[4/5] lg:aspect-auto lg:h-[750px]">
                    <!-- Main Immersive Image -->
                    <img src="https://images.unsplash.com/photo-1542013936693-884638332954?q=80&w=1200" 
                         class="w-full h-full object-cover grayscale opacity-50 transition-all duration-1000 group-hover:grayscale-0 group-hover:scale-105 group-hover:opacity-80" 
                         alt="Scientific Plumbing Methodology">
                    
                    <!-- Overlay: Trust Manifesto -->
                    <div class="absolute inset-0 bg-gradient-to-t from-secondary via-secondary/40 to-transparent"></div>
                    
                    <!-- Floating Logic Cards -->
                    <div class="absolute inset-x-8 bottom-8 p-10 bg-white/10 backdrop-blur-3xl rounded-[3rem] border border-white/20 shadow-2xl">
                        <div class="flex flex-col md:flex-row items-center gap-10 md:divide-x md:divide-white/10">
                            <!-- Column 1: Eco Guarantee -->
                            <div class="flex-1 text-center md:text-left">
                                <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center mb-4 mx-auto md:mx-0 shadow-lg shadow-primary/20">
                                    <i class="ri-leaf-line text-2xl"></i>
                                </div>
                                <h6 class="text-white font-black text-xl mb-2 tracking-tight">100% Eco-Safe</h6>
                                <p class="text-gray-400 text-xs font-medium">Tanpa bahan kimia keras yang merusak struktur pipa bangunan Anda.</p>
                            </div>

                            <!-- Column 2: Health Focused -->
                            <div class="flex-1 text-center md:text-left md:pl-10">
                                <div class="w-12 h-12 rounded-full bg-accent text-white flex items-center justify-center mb-4 mx-auto md:mx-0 shadow-lg shadow-accent/20">
                                    <i class="ri-shield-heart-line text-2xl"></i>
                                </div>
                                <h6 class="text-white font-black text-xl mb-2 tracking-tight">Health First</h6>
                                <p class="text-gray-400 text-xs font-medium">Metode pengerjaan higienis untuk menjaga keamanan penghuni rumah.</p>
                            </div>
                        </div>

                        <!-- Progress Line Indicator -->
                        <div class="mt-10 pt-8 border-t border-white/10 flex flex-wrap justify-center md:justify-start gap-4">
                             @foreach(['Aman & Teruji', 'Tanpa Bongkar', 'Hasil Permanen', 'Garansi Kepuasan'] as $tag)
                                <div class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-white font-black text-[9px] uppercase tracking-widest">{{ $tag }}</div>
                             @endforeach
                        </div>
                    </div>

                    <!-- Modern Badge -->
                    <div class="absolute top-10 right-10 flex flex-col items-end gap-2">
                        <div class="px-6 py-2 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-2xl">Premium Quality</div>
                        <div class="px-6 py-2 bg-secondary/80 text-white text-[10px] font-black uppercase tracking-widest rounded-full backdrop-blur-md">Trusted Method</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Final Trust Row: Competitive Advantages (Clean Minimal Icons) -->
        <div class="mt-32 grid grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                ['icon' => 'ri-sparkling-fill', 'title' => 'Kerja Bersih', 'sub' => 'Area pengerjaan rapi'],
                ['icon' => 'ri-user-star-fill', 'title' => 'Master Technician', 'sub' => 'Sertifikasi keahlian'],
                ['icon' => 'ri-rocket-2-fill', 'title' => 'Speed Service', 'sub' => 'Tiba dalam 45 menit'],
                ['icon' => 'ri-verified-badge-fill', 'title' => 'Verified Results', 'sub' => 'Laporan inspeksi akhir']
            ] as $advantage)
                <div class="flex flex-col items-center text-center p-8 bg-white/5 rounded-[2.5rem] border border-white/10 hover:-translate-y-2 transition-transform shadow-xl">
                    <div class="w-20 h-20 rounded-[2rem] bg-secondary flex items-center justify-center text-primary mb-6 shadow-2xl group-hover:rotate-6 transition-transform">
                        <i class="{{ $advantage['icon'] }} text-4xl"></i>
                    </div>
                    <h5 class="text-white font-black text-lg mb-1">{{ $advantage['title'] }}</h5>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">{{ $advantage['sub'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
