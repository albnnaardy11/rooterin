@extends('layouts.app')

@section('content')
<section class="relative pt-32 pb-20 overflow-hidden bg-stone-50">
    <!-- Decor -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-secondary/5 -skew-x-12 translate-x-1/4"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl">
            <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-primary">Area Layanan</span>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-slate-800">{{ $city->name }}</span>
            </nav>

            <h1 class="text-5xl md:text-7xl font-heading font-black text-slate-900 leading-none mb-8">
                Solusi Pipa Mampet <span class="text-primary italic">#1</span> di {{ $city->name }}.
            </h1>
            
            <p class="text-xl text-slate-600 leading-relaxed mb-12 max-w-2xl">
                Rooterin hadir sebagai mitra terpercaya warga <strong>{{ $city->name }}</strong> untuk menangani saluran pipa mampet, wastafel tersumbat, dan pembersihan drainase dengan teknologi tercanggih tanpa bongkar.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="https://wa.me/6281234567890?text=Halo%20RooterIn%20{{ $city->name }}%2C%20saya%20mau%20order%20jasa" 
                   onclick="trackWhatsAppClick('city-landing')"
                   class="inline-flex items-center gap-3 px-8 py-5 bg-secondary text-white rounded-full font-bold hover:scale-105 transition-all shadow-xl shadow-secondary/20">
                    <i class="ri-whatsapp-line text-xl"></i>
                    Panggil RooterIn {{ $city->name }}
                </a>
                <div class="flex items-center gap-4 px-6 py-4 bg-white rounded-full border border-slate-100 shadow-sm">
                    <div class="flex -space-x-2">
                        @for($i=1;$i<=3;$i++)
                        <img src="https://i.pravatar.cc/100?u={{ $i }}" class="w-8 h-8 rounded-full border-2 border-white" alt="Client">
                        @endfor
                    </div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">+500 Pelanggan di {{ $city->name }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="container mx-auto px-6 text-center mb-16">
        <h2 class="text-3xl font-heading font-black text-slate-900 mb-4">Layanan Unggulan di {{ $city->name }}</h2>
        <p class="text-slate-500">Pilih layanan yang Anda butuhkan untuk wilayah {{ $city->name }}</p>
    </div>

    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($services as $service)
            <a href="{{ route('local.service', [$city->slug, $service->slug]) }}" class="group relative p-10 rounded-[2.5rem] bg-stone-50 border border-slate-100 hover:bg-secondary hover:border-secondary transition-all duration-500 overflow-hidden">
                <!-- Icon -->
                <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-secondary mb-8 shadow-sm group-hover:scale-110 transition-transform duration-500">
                    <i class="ri-tools-line text-3xl"></i>
                </div>
                
                <h3 class="text-2xl font-black text-slate-900 group-hover:text-white mb-4 transition-colors">{{ $service->name }}</h3>
                <p class="text-slate-500 group-hover:text-white/80 transition-colors leading-relaxed mb-8">
                    Layanan khusus {{ $service->name }} untuk area {{ $city->name }} dengan estimasi kedatangan 30-60 menit.
                </p>

                <div class="inline-flex items-center gap-2 text-secondary group-hover:text-white font-black text-sm uppercase tracking-widest transition-colors">
                    Lihat Detail & Harga
                    <i class="ri-arrow-right-line group-hover:translate-x-2 transition-transform"></i>
                </div>

                <!-- Bg Pattern -->
                <div class="absolute -bottom-8 -right-8 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="ri-map-pin-2-fill text-9xl"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-24 bg-stone-50 border-y border-slate-100">
    <div class="container mx-auto px-6">
        <div class="bg-secondary p-12 md:p-20 rounded-[4rem] text-center relative overflow-hidden">
            <!-- Graphics -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <div class="absolute top-10 left-10 w-40 h-40 border-4 border-white rounded-full"></div>
                <div class="absolute bottom-10 right-10 w-60 h-60 border-4 border-white/20 rounded-full"></div>
            </div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <span class="inline-block px-4 py-1 bg-white/10 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-8">Teknisi Standby</span>
                <h2 class="text-4xl md:text-5xl font-heading font-black text-white mb-8">Sedang Ada Masalah Pipa di {{ $city->name }}?</h2>
                <p class="text-white/70 text-lg mb-12 italic">"Jangan tunggu banjir, hubungi RooterIn sekarang sebelum masalah menjadi lebih besar dan mahal."</p>
                
                <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                    <a href="https://wa.me/6281234567890?text=Order%20RooterIn%20{{ $city->name }}" class="px-10 py-5 bg-white text-secondary rounded-full font-black hover:scale-110 transition-all shadow-xl">
                        Chat Admin {{ $city->name }}
                    </a>
                    <div class="text-left">
                        <p class="text-white/60 text-[10px] font-black uppercase tracking-widest mb-1">Telepon Darurat</p>
                        <p class="text-white text-xl font-bold">0812-3456-7890</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
