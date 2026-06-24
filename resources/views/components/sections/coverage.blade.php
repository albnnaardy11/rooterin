@props([
    'title' => 'Melayani Seluruh Jantung Kota Anda',
    'subtitle' => 'Area Jangkauan Terdekat',
    'description' => 'Jaringan teknisi profesional kami tersebar luas untuk menjamin <span class="text-primary font-bold">Fast-Response 15 Menit</span> di setiap titik layanan.',
    'cities' => [
        ['name' => 'JABODETABEK', 'img' => asset('images/pages/home/region/jabodetabek.png'), 'tag' => 'Pusat Operasional'],
        ['name' => 'CIREBON', 'img' => asset('images/pages/home/region/cirebon.png'), 'tag' => 'Jawa Barat Area'],
        ['name' => 'SEMARANG', 'img' => asset('images/pages/home/region/semarang.png'), 'tag' => 'Jawa Tengah Area'],
        ['name' => 'YOGYAKARTA', 'img' => asset('images/pages/home/region/yogyakarta.png'), 'tag' => 'D.I. Yogyakarta'],
        ['name' => 'LAMPUNG', 'img' => asset('images/pages/home/region/lampung.png'), 'tag' => 'Sumatera Area'],
        ['name' => 'METRO', 'img' => asset('images/pages/home/region/metro.png'), 'tag' => 'Sumatera Area'],
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
                <div class="group relative bg-white border border-gray-100 rounded-[2.5rem] p-6 flex items-center gap-6 shadow-xl shadow-gray-100/50 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-2xl hover:border-[#1FAF5A]/50">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden shadow-md flex-shrink-0 group-hover:scale-105 transition-transform duration-500 bg-gray-100">
                        <img src="{{ $city['img'] }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="Tim teknisi Rooterin melayani area {{ $city['name'] }} dan sekitarnya">
                    </div>
                    <div>
                        <div class="text-primary font-bold text-[10px] uppercase tracking-widest mb-1">{{ $city['tag'] }}</div>
                        <h3 class="text-secondary font-black text-xl tracking-tight leading-none mb-1">{{ $city['name'] }}</h3>
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
