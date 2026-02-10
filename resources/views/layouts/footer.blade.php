<!-- Unique Organic Footer -->
<footer class="bg-secondary text-white pt-24 pb-12 relative overflow-hidden">
    <!-- Abstract Background Elements -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-primary/10 rounded-full blur-[120px] pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-6 sm:px-10 relative z-10">
        <div class="flex flex-col lg:flex-row justify-between gap-20 mb-20">
            <!-- Brand & Big Statement -->
            <div class="lg:w-2/5">
                <div class="flex items-center gap-4 mb-8 group cursor-default">
                    <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20 transition-transform duration-500 group-hover:rotate-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-heading font-black text-3xl tracking-tighter">ROOTER<span class="text-primary italic">GREEN</span></span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-heading font-black text-white leading-[1.1] mb-8">
                    Menjaga <span class="text-primary">Aliran</span>, <br>Menjaga <span class="text-gray-500 italic">Masa Depan.</span>
                </h2>
                <p class="text-gray-400 text-lg leading-relaxed mb-10 max-w-md">
                    Layanan plumbing premium pertama di Indonesia yang menggabungkan teknologi modern dengan visi pelestarian alam.
                </p>
                <!-- Social Links with Animation -->
                <div class="flex gap-4">
                    @foreach(['Instagram' => 'M12 2.163...', 'TikTok' => 'M12.525.02...'] as $name => $svg)
                    <a href="#" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-primary hover:border-primary transition-all duration-500 group">
                        <span class="sr-only">{{ $name }}</span>
                        <!-- Using generic social icons for brevity -->
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            @if($name == 'Instagram')
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            @else
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.05 3.5 3.18 1.57.12 3.14-.49 4.14-1.66.72-.94 1.04-2.13 1.04-3.32.01-4.52.01-9.05 0-13.57.06-.06.12-.11.18-.17 1.34-1.33 2.18-3.15 2.18-5.06.01-.06.01-.11.02-.17z"/>
                            @endif
                        </svg>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Links Grid -->
            <div class="lg:w-1/2 grid grid-cols-2 md:grid-cols-3 gap-12 sm:gap-16">
                <!-- Solutions -->
                <div>
                    <h4 class="text-white font-black text-sm uppercase tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-2 bg-primary rounded-full"></span> Solusi
                    </h4>
                    <ul class="space-y-4 text-gray-400 font-bold text-sm">
                        @foreach(['Pipa Dapur', 'Saluran Kamar Mandi', 'WC Mampet', 'Deteksi Kebocoran', 'Rooter Spiral'] as $item)
                        <li><a href="#" class="hover:text-white transition-colors">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- Support -->
                <div>
                    <h4 class="text-white font-black text-sm uppercase tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-2 bg-accent rounded-full"></span> Dukungan
                    </h4>
                    <ul class="space-y-4 text-gray-400 font-bold text-sm">
                        @foreach(['Jangkauan Wilayah', 'Daftar Harga', 'Promo Terbaru', 'Karir Teknisi'] as $item)
                        <li><a href="#" class="hover:text-white transition-colors">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- Contact (Unique Icon Style) -->
                <div class="col-span-2 md:col-span-1">
                    <h4 class="text-white font-black text-sm uppercase tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-2 bg-white rounded-full"></span> Hotline
                    </h4>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/5">
                            <div class="w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2.5"/></svg>
                            </div>
                            <div>
                                <div class="text-[9px] text-gray-500 font-black uppercase tracking-widest">Call & WA</div>
                                <div class="text-white font-black text-xs">0812-3456-7890</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/5">
                            <div class="w-10 h-10 bg-accent/20 rounded-xl flex items-center justify-center text-accent">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5"/></svg>
                            </div>
                            <div>
                                <div class="text-[9px] text-gray-500 font-black uppercase tracking-widest">Respon Cepat</div>
                                <div class="text-white font-black text-xs">15-30 Menit Tiba</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">© {{ date('Y') }} Rooter Green Indonesia</p>
                <div class="hidden md:block w-1.5 h-1.5 bg-white/10 rounded-full"></div>
                <div class="flex gap-4 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <a href="#" class="hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-[10px] text-gray-500 font-black uppercase tracking-widest">Proudly Made In</span>
                <span class="text-white font-black tracking-tighter text-sm flex items-center gap-1">
                    INDONESIA 
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                    </span>
                </span>
            </div>
        </div>
    </div>
</footer>
