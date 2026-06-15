@php
    // JSON-LD Service & Offer Catalog for Premium E-E-A-T
    $serviceCatalogSchema = json_encode([
        "@context" => "https://schema.org",
        "@type" => "Service",
        "name" => "Jasa Saluran Mampet & Plumbing Profesional - RooterIN",
        "serviceType" => "Plumbing & Drain Cleaning Service",
        "provider" => [
            "@type" => "LocalBusiness",
            "name" => "RooterIN",
            "image" => url('/images/logo.png'),
            "telephone" => "+62-812-9205-9125",
            "priceRange" => "Rp 600.000 - Rp 2.500.000",
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => "Jakarta Selatan",
                "addressLocality" => "Jakarta",
                "addressRegion" => "DKI Jakarta",
                "postalCode" => "12000",
                "addressCountry" => "ID"
            ]
        ],
        "hasOfferCatalog" => [
            "@type" => "OfferCatalog",
            "name" => "Daftar Biaya Jasa Plumbing RooterIN",
            "itemListElement" => [
                [
                    "@type" => "Offer",
                    "itemOffered" => [
                        "@type" => "Service",
                        "name" => "Jasa Saluran Mampet (Rumah Hunian)",
                        "description" => "Mengatasi pipa wastafel, kamar mandi, toilet, dan talang mampet dengan mesin spiral mekanis modern tanpa bongkar."
                    ],
                    "price" => "600000",
                    "priceCurrency" => "IDR",
                    "availability" => "https://schema.org/InStock"
                ],
                [
                    "@type" => "Offer",
                    "itemOffered" => [
                        "@type" => "Service",
                        "name" => "Jasa Saluran Mampet (Komersial / Restoran)",
                        "description" => "Melancarkan saluran grease trap dan pipa pembuangan restoran atau ruko komersial dari kerak lemak keras."
                    ],
                    "price" => "800000",
                    "priceCurrency" => "IDR",
                    "availability" => "https://schema.org/InStock"
                ],
                [
                    "@type" => "Offer",
                    "itemOffered" => [
                        "@type" => "Service",
                        "name" => "Cuci Toren & Tangki Air",
                        "description" => "Pembersihan dan sterilisasi tangki air toren dari lumut, endapan lumpur, dan bakteri."
                    ],
                    "price" => "200000",
                    "priceCurrency" => "IDR",
                    "availability" => "https://schema.org/InStock"
                ]
            ]
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

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
                "name" => "Harga Jasa",
                "item" => request()->url()
            ]
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    $faqs = [
        [
            'q' => 'Apakah biaya jasa ditentukan per titik atau per meter?',
            'a' => 'RooterIN menerapkan sistem tarif per titik masalah, bukan per meter. Ini jauh lebih menguntungkan karena Anda sudah tahu pasti berapa biaya yang harus dibayar sejak awal tanpa khawatir pipa yang panjang.'
        ],
        [
            'q' => 'Bagaimana jika setelah dikerjakan saluran tetap mampet?',
            'a' => 'Kami mengutamakan kepuasan pelanggan dengan prinsip "No Cure, No Pay". Jika kami tidak berhasil melancarkan saluran mampet Anda, Anda tidak dikenakan biaya jasa sama sekali.'
        ],
        [
            'q' => 'Apakah ada garansi setelah pengerjaan selesai?',
            'a' => 'Ya, kami memberikan garansi tertulis selama 30 hari sejak pengerjaan selesai. Jika saluran Anda mampet kembali dalam masa garansi, teknisi kami akan datang membersihkannya secara gratis.'
        ],
        [
            'q' => 'Berapa lama proses pengerjaan saluran mampet?',
            'a' => 'Rata-rata pengerjaan membutuhkan waktu 1 hingga 2 jam, tergantung tingkat keparahan sumbatan dan panjang saluran pipa.'
        ],
        [
            'q' => 'Apa metode pembayaran yang diterima?',
            'a' => 'Kami menerima pembayaran tunai (cash) langsung ke teknisi, transfer bank, maupun scan QRIS setelah pengerjaan selesai dilakukan dan berhasil.'
        ]
    ];

    $faqEntities = array_map(function($faq) {
        return [
            "@type" => "Question",
            "name" => $faq['q'],
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => strip_tags($faq['a'])
            ]
        ];
    }, $faqs);

    $faqSchemaJson = json_encode([
        "@context" => "https://schema.org",
        "@type" => "FAQPage",
        "mainEntity" => $faqEntities
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    $semanticSchema = "<script type=\"application/ld+json\">\n" . $serviceCatalogSchema . "\n</script>\n<script type=\"application/ld+json\">\n" . $breadcrumbSchema . "\n</script>\n<script type=\"application/ld+json\">\n" . $faqSchemaJson . "\n</script>";
@endphp

<x-app-layout :semanticSchema="$semanticSchema">
    <!-- Hero Section -->
    <section class="relative bg-secondary pt-36 sm:pt-48 pb-20 sm:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-accent/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block px-5 py-2 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-6 shadow-xl shadow-primary/20">
                TARIF TRANSPARAN & RESMI
            </span>
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-heading font-black text-white leading-none tracking-tighter mb-8">
                Daftar Biaya & <br>
                <span class="text-primary italic">Harga Jasa Plumbing.</span>
            </h1>
            <p class="text-gray-400 text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed font-medium">
                Biaya terjangkau dengan teknologi modern tanpa bongkar. Pengerjaan cepat, garansi tertulis 30 hari, tanpa biaya tambahan tersembunyi.
            </p>
        </div>

        <!-- Wave Transition -->
        <div class="absolute bottom-0 -left-[5%] w-[110%] overflow-hidden leading-[0] z-20 translate-y-[1px]">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-[60px] sm:h-[100px]">
                <path fill="currentColor" class="text-stone-50" d="M0,100 C150,110 300,70 450,90 C600,110 750,130 900,110 C1050,90 1200,110 1200,110 L1200,120 L0,120 Z"></path>
            </svg>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="py-20 bg-stone-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-5xl font-heading font-black text-secondary tracking-tight">Pilih Paket Layanan Kami</h2>
                <p class="text-slate-500 mt-4 max-w-xl mx-auto">Kami menyediakan tarif flat per-titik masalah untuk memudahkan Anda memperkirakan biaya pengerjaan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                <!-- Card 1: Saluran Mampet Residensial -->
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.03)] flex flex-col justify-between relative group hover:scale-[1.02] transition-all duration-500">
                    <div>
                        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-8">
                            <i class="ri-home-4-line text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-heading font-black text-secondary mb-2">Saluran Mampet Hunian</h3>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-6">Untuk Rumah, Kos, & Kontrakan</p>
                        <hr class="border-slate-100 mb-6">
                        <div class="mb-6">
                            <span class="text-slate-400 text-sm font-bold">Mulai dari</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="text-secondary font-heading font-black text-4xl sm:text-5xl">Rp 600K</span>
                                <span class="text-slate-400 text-xs font-bold">/ titik</span>
                            </div>
                        </div>
                        <ul class="space-y-4 mb-10 text-slate-500 text-sm font-medium">
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Wastafel / Cuci Piring Mampet
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Kamar Mandi / Floor Drain
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Talang Air Hujan
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Kloset / Toilet Mampet
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Garansi 30 Hari Penuh
                            </li>
                        </ul>
                    </div>
                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281292059125') }}?text=Halo%20RooterIN,%20saya%20ingin%20memesan%20Jasa%20Saluran%20Mampet%20Rumah%20Hunian" class="w-full py-4 text-center bg-secondary text-white font-black uppercase text-[10px] tracking-widest rounded-2xl hover:bg-primary transition-colors shadow-lg shadow-secondary/10">Pesan Sekarang</a>
                </div>

                <!-- Card 2: Saluran Mampet Komersial (Popular) -->
                <div class="bg-secondary rounded-[3rem] p-10 shadow-[0_30px_70px_rgba(0,0,0,0.15)] flex flex-col justify-between relative group hover:scale-[1.02] transition-all duration-500 border border-secondary/10">
                    <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-primary text-white font-black uppercase text-[9px] tracking-widest px-6 py-2.5 rounded-full shadow-lg">
                        PALING DIIMPOR
                    </div>
                    <div>
                        <div class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-primary/20">
                            <i class="ri-hotel-line text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-heading font-black text-white mb-2">Saluran Komersial</h3>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-6">Restoran, Ruko, Kantor, & Hotel</p>
                        <hr class="border-white/10 mb-6">
                        <div class="mb-6">
                            <span class="text-gray-400 text-sm font-bold">Estimasi</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="text-primary font-heading font-black text-4xl sm:text-5xl">Rp 800K</span>
                                <span class="text-gray-400 text-xs font-bold">- 1.8M</span>
                            </div>
                        </div>
                        <ul class="space-y-4 mb-10 text-gray-300 text-sm font-medium">
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-primary text-lg"></i>
                                Pembersihan Kerak Lemak Keras
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-primary text-lg"></i>
                                Saluran Bak Kontrol Utama
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-primary text-lg"></i>
                                Pembersihan Grease Trap
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-primary text-lg"></i>
                                Pembersihan Pipa Diameter Besar
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-primary text-lg"></i>
                                Garansi Penuh 30 Hari
                            </li>
                        </ul>
                    </div>
                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281292059125') }}?text=Halo%20RooterIN,%20saya%20ingin%20memesan%20Jasa%20Saluran%20Mampet%20Komersial" class="w-full py-4 text-center bg-primary text-white font-black uppercase text-[10px] tracking-widest rounded-2xl hover:bg-white hover:text-secondary transition-all shadow-xl shadow-primary/20">Pesan Sekarang</a>
                </div>

                <!-- Card 3: Air Bersih & Cuci Toren -->
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.03)] flex flex-col justify-between relative group hover:scale-[1.02] transition-all duration-500">
                    <div>
                        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-8">
                            <i class="ri-drop-line text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-heading font-black text-secondary mb-2">Air Bersih & Toren</h3>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-6">Sterilisasi Tangki Air</p>
                        <hr class="border-slate-100 mb-6">
                        <div class="mb-6">
                            <span class="text-slate-400 text-sm font-bold">Mulai dari</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="text-secondary font-heading font-black text-4xl sm:text-5xl">Rp 200K</span>
                                <span class="text-slate-400 text-xs font-bold">/ unit</span>
                            </div>
                        </div>
                        <ul class="space-y-4 mb-10 text-slate-500 text-sm font-medium">
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Cuci Tangki Air / Toren (Up to 1000L)
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Sterilisasi dari Lumut & Lumpur
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Pengecekan Kran Mampet (Survey)
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Normalisasi Sirkulasi Air Bersih
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-500 text-lg"></i>
                                Standar Higienis Terbaik
                            </li>
                        </ul>
                    </div>
                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281292059125') }}?text=Halo%20RooterIN,%20saya%20ingin%20memesan%20Jasa%20Cuci%20Toren%20Air" class="w-full py-4 text-center bg-secondary text-white font-black uppercase text-[10px] tracking-widest rounded-2xl hover:bg-primary transition-colors shadow-lg shadow-secondary/10">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Area Served Table -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-black text-primary uppercase tracking-[0.2em]">LOCAL BUSINESS coverage</span>
                <h2 class="text-3xl sm:text-4xl font-heading font-black text-secondary tracking-tight mt-2">Daftar Estimasi Tarif per Wilayah</h2>
                <p class="text-slate-400 mt-2 text-sm">Tidak ada biaya transport tambahan untuk kota-kota di bawah ini.</p>
            </div>

            <div class="bg-stone-50 rounded-[2.5rem] p-8 border border-slate-100 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm font-medium">
                        <thead>
                            <tr class="border-b border-slate-200/60 text-secondary font-black uppercase text-[10px] tracking-wider">
                                <th class="pb-4">Wilayah Layanan</th>
                                <th class="pb-4 text-center">Estimasi Waktu Tiba</th>
                                <th class="pb-4 text-right">Biaya Kunjungan & Survey</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            @foreach([
                                ['Jakarta', '1-2 Jam', 'GRATIS'],
                                ['Bogor, Depok', '2-3 Jam', 'GRATIS (Jika Dikerjakan)'],
                                ['Tangerang, Bekasi', '1.5-2.5 Jam', 'GRATIS'],
                                ['Denpasar, Badung, Gianyar (Bali)', '1-2 Jam', 'GRATIS'],
                                ['Bandung Kota', '1.5-2 Jam', 'GRATIS'],
                                ['Serang (Banten)', '2-3 Jam', 'GRATIS (Jika Dikerjakan)'],
                                ['Bandar Lampung', '2-3 Jam', 'GRATIS (Jika Dikerjakan)'],
                            ] as $area)
                                <tr>
                                    <td class="py-4 font-bold text-secondary">{{ $area[0] }}</td>
                                    <td class="py-4 text-center text-slate-500">{{ $area[1] }}</td>
                                    <td class="py-4 text-right font-black text-primary">{{ $area[2] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section (Helps SEO CTR & Rich Snippets) -->
    <section class="py-20 bg-stone-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-heading font-black text-secondary tracking-tight">Pertanyaan Terkait Biaya</h2>
                <p class="text-slate-500 mt-2">Segala hal yang perlu Anda ketahui tentang tarif dan sistem garansi RooterIN.</p>
            </div>

            <div class="space-y-6" x-data="{ activeFaq: null }">
                @foreach($faqs as $index => $faq)
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden transition-all duration-300">
                        <button 
                            @click="activeFaq === {{ $index }} ? activeFaq = null : activeFaq = {{ $index }}"
                            class="w-full py-6 px-8 flex items-center justify-between text-left font-black text-secondary hover:text-primary transition-colors focus:outline-none">
                            <span class="text-base sm:text-lg">{{ $faq['q'] }}</span>
                            <i class="text-xl transition-transform duration-300" :class="activeFaq === {{ $index }} ? 'ri-subtract-line rotate-180 text-primary' : 'ri-add-line text-slate-400'"></i>
                        </button>
                        <div 
                            x-show="activeFaq === {{ $index }}"
                            x-collapse
                            class="px-8 pb-6 text-slate-500 text-sm leading-relaxed border-t border-slate-50/50 pt-4">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Emergency CTA -->
    <section class="py-20 bg-secondary relative overflow-hidden">
        <div class="absolute inset-0 bg-primary/5 -z-0"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl sm:text-5xl font-heading font-black text-white leading-tight mb-6">Konsultasikan Masalah Pipa Anda Gratis!</h2>
            <p class="text-gray-400 text-base sm:text-lg mb-10 max-w-xl mx-auto">Kirimkan video atau foto masalah pipa Anda ke tim ahli kami untuk mendapatkan estimasi biaya yang presisi.</p>
            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281292059125') }}?text=Halo%20RooterIN,%20saya%20mau%20konsultasi%20masalah%20pipa%20mampet" class="inline-flex items-center gap-4 bg-primary px-10 py-5 rounded-full shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all text-white font-black uppercase tracking-widest text-xs">
                Hubungi via WhatsApp
                <i class="ri-whatsapp-line text-lg"></i>
            </a>
        </div>
    </section>
</x-app-layout>
