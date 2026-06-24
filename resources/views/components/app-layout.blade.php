<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! \Artesaos\SEOTools\Facades\SEOTools::generate() !!}
    
    <!-- Open Graph / SEO Meta Tags -->
    <meta name="description" content="RooterIn menyediakan jasa saluran mampet profesional, pembersihan pipa, cuci toren, dan instalasi sanitary tanpa proses bongkar dan bergaransi 30 hari.">
    <meta property="og:title" content="RooterIn - Jasa Saluran Mampet & Pipe Cleaning Premium">
    <meta property="og:description" content="Mengatasi pipa mampet, wastafel tersumbat, dan saluran pembuangan air kotor secara tuntas tanpa membongkar pipa Anda. Hubungi teknisi kami 24 jam!">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    {{-- Hreflang Automator --}}
    {!! $hreflangTags ?? '' !!}
    
    {{-- Headless Semantic Entity Graph --}}
    {!! $semanticSchema ?? '' !!}

    {{-- ================================================================
         ENTITY AUTHORITY SCHEMA — LocalBusiness + Organization
         Full E-E-A-T & Local SEO Signal for Google Domination
         ================================================================ --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": ["LocalBusiness", "PlumbingContractor"],
      "@@id": "{{ url('/') }}/#rooterin-business",
      "name": "RooterIN",
      "legalName": "RooterIN - Jasa Saluran Mampet Profesional",
      "description": "RooterIN adalah jasa plumbing & saluran mampet terpercaya yang melayani wilayah Jabodetabek, Bali, Bandung, Serang, Lampung dan kota-kota besar Indonesia. Teknisi tersertifikasi, fast response 24 jam.",
      "url": "{{ url('/') }}",
      "logo": {
        "@@type": "ImageObject",
        "url": "{{ url('/images/logo.png') }}",
        "width": 200,
        "height": 60
      },
      "image": [
        "{{ url('/images/logo.png') }}"
      ],
      "telephone": "+62-812-9205-9125",
      "email": "hello@rooterin.com",
      "priceRange": "Rp 600.000 - Rp 2.500.000",
      "currenciesAccepted": "IDR",
      "paymentAccepted": "Cash, Transfer Bank, QRIS",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "Jakarta Selatan",
        "addressLocality": "Jakarta",
        "addressRegion": "DKI Jakarta",
        "postalCode": "12000",
        "addressCountry": "ID"
      },
      "geo": {
        "@@type": "GeoCoordinates",
        "latitude": "-6.2088",
        "longitude": "106.8456"
      },
      "openingHoursSpecification": [
        {
          "@@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
          "opens": "00:00",
          "closes": "23:59"
        }
      ],
      "areaServed": [
        { "@@type": "City", "name": "Jakarta" },
        { "@@type": "City", "name": "Bogor" },
        { "@@type": "City", "name": "Depok" },
        { "@@type": "City", "name": "Tangerang" },
        { "@@type": "City", "name": "Bekasi" },
        { "@@type": "City", "name": "Bandung" },
        { "@@type": "City", "name": "Serang" },
        { "@@type": "City", "name": "Lampung" },
        { "@@type": "City", "name": "Denpasar" },
        { "@@type": "City", "name": "Badung" },
        { "@@type": "City", "name": "Gianyar" },
        { "@@type": "State", "name": "DKI Jakarta" },
        { "@@type": "State", "name": "Jawa Barat" },
        { "@@type": "State", "name": "Banten" },
        { "@@type": "State", "name": "Bali" }
      ],
      "serviceArea": {
        "@@type": "GeoCircle",
        "geoMidpoint": {
          "@@type": "GeoCoordinates",
          "latitude": "-6.2088",
          "longitude": "106.8456"
        },
        "geoRadius": "500000"
      },
      "sameAs": [
        "https://www.instagram.com/rooterin",
        "https://www.facebook.com/rooterin",
        "https://www.tiktok.com/@rooterin",
        "https://wa.me/6281292059125"
      ],
      "aggregateRating": {
        "@@type": "AggregateRating",
        "ratingValue": "4.9",
        "bestRating": "5",
        "worstRating": "1",
        "ratingCount": "247",
        "reviewCount": "189"
      },
      "hasOfferCatalog": {
        "@@type": "OfferCatalog",
        "name": "Jasa Plumbing & Saluran Mampet",
        "itemListElement": [
          {
            "@@type": "Offer",
            "itemOffered": {
              "@@type": "Service",
              "name": "Jasa Saluran Mampet",
              "description": "Bersihkan saluran pembuangan mampet dengan mesin spiral modern tanpa bongkar."
            },
            "price": "600000",
            "priceCurrency": "IDR",
            "availability": "https://schema.org/InStock"
          },
          {
            "@@type": "Offer",
            "itemOffered": {
              "@@type": "Service",
              "name": "Cuci Toren & Tangki Air",
              "description": "Sterilisasi tangki air bersih dari lumut dan sedimentasi."
            },
            "price": "200000",
            "priceCurrency": "IDR",
            "availability": "https://schema.org/InStock"
          },
          {
            "@@type": "Offer",
            "itemOffered": {
              "@@type": "Service",
              "name": "Instalasi Sanitary & Pipa",
              "description": "Pemasangan kloset, kran, dan jalur pipa baru dengan standar profesional."
            },
            "price": "0",
            "priceCurrency": "IDR",
            "priceSpecification": {
              "@@type": "PriceSpecification",
              "description": "Harga berdasarkan survey lokasi"
            },
            "availability": "https://schema.org/InStock"
          }
        ]
      },
      "knowsAbout": [
        "Plumbing", "Saluran Mampet", "Pipa PVC", "Instalasi Sanitary",
        "Cuci Toren", "Grease Trap", "Septic Tank", "Hydro Jetting"
      ],
      "founder": {
        "@@type": "Person",
        "name": "Tim Ahli RooterIN",
        "jobTitle": "Master Plumber"
      }
    }
    </script>

    <script>
        function trackWhatsAppClick(source = 'general') {
            fetch('/api/track-whatsapp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    url: window.location.href,
                    source: source
                })
            });
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Local Edge Pre-Rendering (Speculative Rules API) --}}
    <script type="speculationrules">
    {
      "prerender": [{
        "source": "list",
        "urls": ["{{ route('home') }}", "{{ route('services') }}"]
      }, {
        "source": "document",
        "where": { "and": [
          { "href_matches": "/area/*" },
          { "not": { "href_matches": "/admin/*" }}
        ]},
        "eagerness": "moderate"
      }]
    }
    </script>
</head>
<body class="font-sans antialiased bg-stone-50 text-slate-800">
    <div id="site-content" class="min-h-screen flex flex-col transition-all duration-300">
        @include('layouts.navigation')

        <main class="flex-grow">
            {{ $slot }}
        </main>

        @include('layouts.footer')
        
        <x-sticky-footer />
    </div>
    
    <x-accessibility-menu />

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => {
                        console.log('Service Worker Registered');
                        // NOTE: Auto-reload disabled to prevent interrupting AI Diagnostic modal
                        // reg.onupdatefound fires but we DON'T force reload anymore
                        reg.onupdatefound = () => {
                            const installingWorker = reg.installing;
                            installingWorker.onstatechange = () => {
                                if (installingWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    console.log('New SW version available (manual refresh to apply).');
                                    // DO NOT auto-reload — would disrupt AI modal result display
                                }
                            };
                        };
                    })
                    .catch(err => console.log('Service Worker Failed', err));
            });
        }
    </script>
</body>
</html>
