@php
    // Author BIOS mapping for E-E-A-T signals
    $authorBios = [
        'Budi Santoso, S.T.' => [
            'title' => 'Senior Plumbing Engineer',
            'bio' => 'Senior Plumbing Engineer dengan 15 tahun pengalaman di bidang sistem sanitasi gedung bertingkat dan residensial di Indonesia.',
            'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop&q=80',
            'expertise' => ['Sistem Plumbing Gedung', 'Sistem Drainase', 'Sanitary Engineering']
        ],
        'Dian Permata, A.Md.' => [
            'title' => 'Teknisi Pipa Bersertifikat',
            'bio' => 'Teknisi Pipa Bersertifikat ahli dalam instalasi sistem plumbing modern, hemat energi, dan ramah lingkungan.',
            'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&h=150&fit=crop&q=80',
            'expertise' => ['Instalasi Pipa Modern', 'Pembersihan Saluran', 'Sistem Ramah Lingkungan']
        ],
        'Reza Kurniawan' => [
            'title' => 'Konsultan Sanitasi Komersial',
            'bio' => 'Konsultan Sanitasi berpengalaman luas dalam merancang dan memelihara instalasi grease trap serta sistem pembuangan restoran di Jabodetabek & Bali.',
            'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150&h=150&fit=crop&q=80',
            'expertise' => ['Grease Trap Restoran', 'Hydro Jetting', 'Sanitasi Komersial']
        ],
        'Siti Rahayu, S.T.' => [
            'title' => 'Ahli Hidrologi & Plumbing',
            'bio' => 'Ahli Hidrologi dengan spesialisasi manajemen sirkulasi air bersih, perawatan toren air, dan pencegahan kontaminasi saluran pipa.',
            'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=150&h=150&fit=crop&q=80',
            'expertise' => ['Manajemen Air Bersih', 'Cuci Toren', 'Sirkulasi Hidrolik']
        ],
        'Tim Ahli RooterIN' => [
            'title' => 'Master Plumber Team',
            'bio' => 'Tim teknisi tersertifikasi RooterIN dengan total pengalaman gabungan lebih dari 50 tahun mengatasi masalah pipa mampet di seluruh Indonesia.',
            'avatar' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=150&h=150&fit=crop&q=80',
            'expertise' => ['Deteksi Kebocoran Pipa', 'Rooter Spiral Mekanis', 'Saluran Mampet Darurat']
        ],
    ];

    $authorName = $post->author ?? 'RooterIN Expert';
    $authorInfo = $authorBios[$authorName] ?? [
        'title' => 'Plumbing Specialist',
        'bio' => 'Spesialis perbaikan saluran pembuangan mampet dan instalasi pipa tersertifikasi dari tim RooterIN.',
        'avatar' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?w=150&h=150&fit=crop&q=80',
        'expertise' => ['Saluran Mampet', 'Emergency Plumbing']
    ];

    // Generate JSON-LD Breadcrumbs
    $breadcrumbSchema = json_encode([
        "@context" => "https://schema.org",
        "@type" => "BreadcrumbList",
        "itemListElement" => [
            [
                "@type" => "ListItem",
                "position" => 1,
                "name" => "Beranda",
                "item" => url('/')
            ],
            [
                "@type" => "ListItem",
                "position" => 2,
                "name" => "Tips",
                "item" => route('tips')
            ],
            [
                "@type" => "ListItem",
                "position" => 3,
                "name" => $post->title,
                "item" => request()->url()
            ]
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    // Generate JSON-LD Article (E-E-A-T Signal)
    $articleSchema = json_encode([
        "@context" => "https://schema.org",
        "@type" => "BlogPosting",
        "mainEntityOfPage" => [
            "@type" => "WebPage",
            "@id" => request()->url()
        ],
        "headline" => $post->title,
        "description" => $post->seo_description ?? Illuminate\Support\Str::limit(strip_tags($post->content), 150),
        "image" => $post->featured_image,
        "datePublished" => $post->created_at->toIso8601String(),
        "dateModified" => $post->updated_at->toIso8601String(),
        "author" => [
            "@type" => "Person",
            "name" => $authorName,
            "jobTitle" => $authorInfo['title'],
            "description" => $authorInfo['bio'],
            "image" => $authorInfo['avatar'],
            "sameAs" => url('/')
        ],
        "publisher" => [
            "@type" => "Organization",
            "name" => "RooterIN",
            "logo" => [
                "@type" => "ImageObject",
                "url" => url('/images/logo.png')
            ]
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    $semanticSchema = "<script type=\"application/ld+json\">\n" . $breadcrumbSchema . "\n</script>\n<script type=\"application/ld+json\">\n" . $articleSchema . "\n</script>";
@endphp

<x-app-layout :semanticSchema="$semanticSchema">

    {{-- 0. Scroll Progress Tracker --}}
    <div x-data="{ 
        percent: 0,
        updateProgress() {
            const h = document.documentElement, 
                  st = 'scrollTop',
                  sh = 'scrollHeight';
            this.percent = (h[st]||document.body[st]) / ((h[sh]||document.body[sh]) - h.clientHeight) * 100;
        }
    }" @scroll.window="updateProgress()" class="fixed top-0 left-0 w-full h-1.5 z-[100] pointer-events-none">
        <div class="h-full bg-primary transition-all duration-150 shadow-[0_0_15px_rgba(var(--color-primary-rgb),0.5)]" :style="`width: ${percent}%`"></div>
    </div>

    <section class="bg-stone-50/50 pt-32 sm:pt-48 pb-40 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumb & Back --}}
            <div class="flex items-center justify-between mb-16">
                <a href="{{ route('tips') }}" class="group flex items-center gap-3 text-secondary font-black text-[11px] uppercase tracking-[0.3em] hover:text-primary transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-[0_10px_20px_rgba(0,0,0,0.02),0_0_20px_white] flex items-center justify-center text-primary group-hover:-translate-x-2 transition-transform">
                        <i class="ri-arrow-left-line text-xl"></i>
                    </div>
                    <span class="ml-2">Kembali Ke Hub</span>
                </a>
                <div class="hidden sm:flex gap-3">
                    @foreach(['ri-whatsapp-line', 'ri-facebook-fill', 'ri-twitter-line'] as $icon)
                        <button class="w-12 h-12 rounded-2xl bg-white shadow-[0_10px_20px_rgba(0,0,0,0.02),0_0_20px_white] flex items-center justify-center text-secondary hover:text-primary hover:shadow-lg hover:shadow-primary/5 transition-all">
                            <i class="{{ $icon }} text-lg"></i>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                
                {{-- Main Content - Contained Style --}}
                <div class="lg:w-2/3">
                    <article class="bg-white rounded-[4rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.04),0_0_60px_white] overflow-hidden border border-white/50">
                        
                        {{-- Integrated Header Image & Title --}}
                        <div class="relative h-[400px] sm:h-[550px] overflow-hidden group">
                            <img src="{{ $post->featured_image }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[3000ms]" loading="lazy" decoding="async">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                            
                            <div class="absolute bottom-12 left-8 right-8 sm:left-16 sm:right-16">
                                <span class="inline-block px-5 py-2 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-6 shadow-xl shadow-primary/20">
                                    {{ $post->category }}
                                </span>
                                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-heading font-black text-white leading-[1.1] mb-8 tracking-tighter">
                                    {{ $post->title }}
                                </h1>
                                <div class="flex items-center gap-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $authorInfo['avatar'] }}" alt="{{ $authorName }}" class="w-10 h-10 rounded-xl object-cover border border-white/20" loading="lazy" decoding="async">
                                        <div class="text-left">
                                            <p class="text-white font-black text-[10px] uppercase tracking-wider leading-none">{{ $authorName }}</p>
                                            <p class="text-white/60 text-[8px] font-bold uppercase tracking-widest mt-1">{{ $authorInfo['title'] }}</p>
                                        </div>
                                    </div>
                                    <div class="w-[1px] h-6 bg-white/20"></div>
                                    <div class="text-white/80 font-black text-[9px] uppercase tracking-[0.2em] flex items-center gap-2">
                                        <i class="ri-calendar-event-line text-primary"></i>
                                        {{ $post->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-white/80 font-black text-[9px] uppercase tracking-[0.2em] hidden sm:flex items-center gap-2">
                                        <i class="ri-time-line text-primary"></i>
                                        {{ ceil(str_word_count($post->content) / 200) }} min read
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Article Body --}}
                        <div class="p-8 sm:p-20 pt-16">
                            <div class="prose prose-xl prose-slate max-w-none prose-headings:font-heading prose-headings:font-black prose-headings:text-secondary prose-headings:tracking-tight prose-p:text-gray-600 prose-p:leading-relaxed prose-strong:text-secondary prose-img:rounded-[2.5rem] prose-blockquote:border-l-primary prose-blockquote:bg-stone-50 prose-blockquote:p-10 prose-blockquote:rounded-[2.5rem] prose-blockquote:italic prose-blockquote:font-medium">
                                {!! nl2br(e($post->content)) !!}
                                
                                <div class="mt-20 p-10 bg-secondary rounded-[3rem] text-white">
                                    <h3 class="text-white !mt-0">Butuh Bantuan Lebih Lanjut?</h3>
                                    <p class="text-gray-400 mb-8">Jika langkah di atas belum berhasil, kemungkinan ada benda keras yang menyangkut. Tim RooterIN siap membantu dengan alat spiral modern.</p>
                                    <a href="https://wa.me/6281234567890" class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-white rounded-2xl font-black uppercase text-[11px] tracking-widest shadow-xl shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
                                        <i class="ri-whatsapp-line text-xl"></i>
                                        Panggil Teknisi
                                    </a>
                                </div>
                            </div>

                            {{-- Author EEAT Signal Box --}}
                            <div class="mt-16 pt-16 border-t border-slate-100">
                                <div class="bg-stone-50 rounded-[2.5rem] p-8 sm:p-10 flex flex-col sm:flex-row items-center sm:items-start gap-8 border border-slate-100">
                                    <div class="relative flex-shrink-0">
                                        <img src="{{ $authorInfo['avatar'] }}" alt="{{ $authorName }}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover border-4 border-white shadow-xl" loading="lazy" decoding="async">
                                        <div class="absolute -bottom-1 -right-1 bg-green-500 text-white w-7 h-7 rounded-full flex items-center justify-center border-2 border-white shadow" title="Penulis Ahli Terverifikasi">
                                            <i class="ri-checkbox-circle-fill text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow text-center sm:text-left">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                                            <div>
                                                <span class="text-[9px] font-black text-primary uppercase tracking-[0.2em] block mb-1">Ditulis Oleh</span>
                                                <h3 class="text-xl font-heading font-black text-secondary !m-0 leading-tight">{{ $authorName }}</h3>
                                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wider">{{ $authorInfo['title'] }}</p>
                                            </div>
                                            <div class="flex flex-wrap gap-1 justify-center sm:justify-start">
                                                @foreach($authorInfo['expertise'] as $exp)
                                                    <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[8px] font-black uppercase tracking-wider rounded-md">{{ $exp }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <p class="text-slate-500 text-sm leading-relaxed mb-4">
                                            {{ $authorInfo['bio'] }}
                                        </p>
                                        <div class="flex items-center justify-center sm:justify-start gap-2 text-xs text-slate-400 font-bold">
                                            <i class="ri-shield-check-line text-lg text-green-500"></i>
                                            <span>Konten Ditinjau Teknis untuk Kebenaran Fakta & Keamanan Pipa</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                {{-- Sidebar - Simplified & Professional --}}
                <div class="lg:w-1/3">
                    <div class="sticky top-32 space-y-10">
                        
                        {{-- SOS Card Slim --}}
                        <div class="bg-white rounded-[3rem] p-10 shadow-[0_30px_80px_rgba(0,0,0,0.03),0_0_50px_white] relative group overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/10 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                            <div class="relative z-10">
                                <h4 class="text-secondary font-black text-xl mb-4 leading-tight">Konsultasi Gratis <br><span class="text-primary italic">Masalah Pipa</span></h4>
                                <p class="text-gray-400 text-sm mb-8 leading-relaxed">Tanya teknisi kami langsung lewat WhatsApp untuk estimasi biaya dan solusi.</p>
                                <a href="https://wa.me/6281234567890" class="flex items-center justify-center gap-3 w-full py-5 bg-secondary text-white rounded-[2rem] font-black uppercase text-[10px] tracking-widest hover:bg-primary transition-all shadow-xl shadow-secondary/10">
                                    <i class="ri-customer-service-2-line text-xl"></i>
                                    Chat Sekarang
                                </a>
                            </div>
                        </div>

                        {{-- Trending Section --}}
                        <div class="bg-white rounded-[3rem] p-10 shadow-[0_30px_80px_rgba(0,0,0,0.03),0_0_50px_white]">
                            <h4 class="text-secondary font-black text-xs uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                                Tips Terpopuler
                            </h4>
                            <div class="space-y-6">
                                @foreach([
                                    'Bahaya Menggunakan Soda Api Pada Pipa PVC',
                                    '5 Tanda Pipa Pembuangan Mulai Berkerak',
                                    'Cara Membersihkan Toren Air Agar Bebas Lumut'
                                ] as $title)
                                    <a href="#" class="group block border-b border-gray-50 pb-6 last:border-0 last:pb-0">
                                        <p class="text-[9px] font-black text-primary uppercase tracking-widest mb-1">Trending</p>
                                        <h5 class="text-secondary font-black text-sm leading-snug group-hover:text-primary transition-colors">{{ $title }}</h5>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Newsletter Card --}}
                        <div class="bg-secondary p-10 rounded-[3rem] text-white overflow-hidden relative">
                            <div class="absolute inset-0 bg-primary/5 -z-0"></div>
                            <div class="relative z-10">
                                <h4 class="text-white font-black text-xl mb-2">Smart Mail</h4>
                                <p class="text-white/40 text-xs mb-8">Berlangganan tips perawatan pipa hemat biaya.</p>
                                <div class="space-y-3">
                                    <input type="email" placeholder="Email Anda..." class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 focus:ring-2 ring-primary transition-all text-sm font-medium text-white placeholder-white/30">
                                    <button class="w-full bg-primary text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">Daftar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Widget Interlinking Dinamis: Kami Melayani Area Anda --}}
    @if(isset($serviceCities) && $serviceCities->count() > 0)
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-stone-50 rounded-[3rem] p-10 border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.03)] relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 mb-8 border-b border-slate-200/50 pb-8">
                    <div>
                        <h3 class="text-2xl font-heading font-black text-secondary flex items-center gap-3">
                            <i class="ri-map-pin-user-fill text-primary text-3xl"></i>
                            Kami Melayani Area Anda
                        </h3>
                        <p class="text-slate-500 mt-2 font-medium">Layanan profesional RooterIN tersedia di kota-kota berikut dengan garansi penuh.</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 relative z-10">
                    @foreach($serviceCities as $city)
                        <a href="{{ route('local.city', $city->slug) }}" class="group/city bg-white border border-slate-100 rounded-2xl p-5 text-center hover:shadow-[0_15px_30px_rgba(0,0,0,0.05),0_0_20px_white] hover:-translate-y-1 transition-all duration-300">
                            <div class="w-12 h-12 mx-auto bg-primary/10 text-primary rounded-full flex items-center justify-center mb-3 group-hover/city:bg-primary group-hover/city:text-white transition-colors">
                                <i class="ri-map-pin-2-fill text-xl"></i>
                            </div>
                            <h4 class="font-black text-secondary text-sm group-hover/city:text-primary transition-colors">{{ $city->name }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

<section class="py-12 sm:py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- The High-Impact CTA Card (Named Group for Isolation) -->
        <div class="relative w-full min-h-[500px] lg:min-h-0 lg:aspect-[21/9] xl:aspect-[21/8] rounded-[2.5rem] sm:rounded-[4rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)] group/cta">
            
            <!-- Background Image from Internet -->
            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2000&auto=format&fit=crop" 
                 alt="RooterIn Professional" 
                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover/cta:scale-110" loading="lazy" decoding="async">
            
            <!-- Darker Gradient Overlay for Maximum Impact -->
            <div class="absolute inset-0 bg-secondary/60 backdrop-blur-[2px]"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-secondary/40 via-secondary/80 to-secondary transition-colors duration-500"></div>
            
            <!-- Content Area: Centered & Powerful -->
            <div class="absolute inset-0 p-6 sm:p-10 lg:p-16 flex flex-col justify-center items-center text-center">
                
                <!-- Centered Badges -->
                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4 mb-6 sm:mb-10">
                    <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-primary text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.3em] rounded-full shadow-xl shadow-primary/30">
                        EMERGENCY
                    </div>
                    <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-white/10 backdrop-blur-xl border border-white/20 rounded-full">
                        <span class="text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.25em]">SIAP MELAYANI 24/7</span>
                    </div>
                </div>

                <!-- Massive Impact Heading -->
                <h2 class="text-2xl sm:text-4xl lg:text-5xl xl:text-7xl font-heading font-black text-white leading-[1.1] sm:leading-[1] tracking-tight mb-8 sm:mb-12 max-w-5xl animate-fade-in-up">
                    Langkah Nyata Menuju <br> 
                    <span class="text-primary italic">Saluran Pipa Lancar.</span>
                </h2>
                
                <!-- Large Prominent White Pill Button (Separate Named Group) -->
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281292059125') }}" 
                   class="inline-flex items-center gap-4 sm:gap-6 bg-white px-8 sm:px-12 lg:px-16 py-4 sm:py-5 lg:py-7 rounded-full shadow-[0_30px_60px_rgba(0,0,0,0.4)] hover:bg-primary transition-all duration-500 group/btn active:scale-95">
                    <span class="text-primary group-hover/btn:text-white font-black text-xs sm:text-base lg:text-xl uppercase tracking-widest transition-colors flex items-center gap-3 sm:gap-4">
                        Hubungi Tim Kami
                        <i class="ri-whatsapp-line text-lg lg:text-2xl transition-transform group-hover/btn:scale-125"></i>
                    </span>
                </a>

            </div>
        </div>
    </div>
</section>

</x-app-layout>
