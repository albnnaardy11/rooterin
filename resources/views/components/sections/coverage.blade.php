@props([
    'title' => 'Melayani Seluruh Jantung Kota Anda',
    'subtitle' => 'PENYINGGAH TERDEKAT',
    'description' => 'Jaringan teknisi profesional kami tersebar luas untuk menjamin <span class="text-primary font-bold">Fast-Response 15 Menit</span> di setiap titik layanan.',
    'cities' => [
        ['name' => 'JABODETABEK', 'img' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=600&fit=crop', 'tag' => 'Pusat Operasional'],
        ['name' => 'CIREBON', 'img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=600&fit=crop', 'tag' => 'Jawa Barat Area'],
        ['name' => 'SEMARANG', 'img' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=600&fit=crop', 'tag' => 'Jawa Tengah Area'],
        ['name' => 'YOGYAKARTA', 'img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=600&fit=crop', 'tag' => 'D.I. Yogyakarta'],
        ['name' => 'LAMPUNG', 'img' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?w=600&fit=crop', 'tag' => 'Sumatera Area'],
        ['name' => 'METRO', 'img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=600&fit=crop', 'tag' => 'Sumatera Area'],
    ]
])

<section id="coverage" {{ $attributes->merge(['class' => 'py-32 bg-white relative overflow-hidden']) }}>
    <!-- Technical Grid Background -->
    <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/grid-me.png')] pointer-events-none"></div>
    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-stone-50 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-24">
            <x-section-heading :title="$title" :subtitle="$subtitle" align="center" />
            <p class="text-gray-500 max-w-2xl mx-auto -mt-8 text-lg font-medium">
                {!! $description !!}
            </p> 
        </div>

        <!-- City Network Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-24">
            @foreach($cities as $city)
                <div class="group relative bg-white border border-gray-100 rounded-[2.5rem] p-6 flex items-center gap-6 shadow-xl shadow-gray-100/50 hover:shadow-2xl hover:shadow-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all duration-500">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden shadow-md flex-shrink-0 group-hover:scale-105 transition-transform duration-500 bg-gray-100">
                        <img src="{{ $city['img'] }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="{{ $city['name'] }}">
                    </div>
                    <div>
                        <div class="text-primary font-bold text-[10px] uppercase tracking-widest mb-1">{{ $city['tag'] }}</div>
                        <h4 class="text-secondary font-black text-xl tracking-tight leading-none mb-1">{{ $city['name'] }}</h4>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse shadow-[0_0_8px_#1FAF5A]"></span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-tight">Active Team</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Premium Coverage Visual (Atomic Part) -->
        <x-parts.coverage-card />
    </div>
</section>
