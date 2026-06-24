<?php

$files = glob(__DIR__ . '/../docs/*.html');

$commonReplacements = [
    // Navbar
    '<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 50)"
     class="fixed top-0 left-0 right-0 z-50 pt-4 sm:pt-10 px-3 sm:px-4 transition-all duration-500 ease-in-out">' => 
    '<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 50)"
     :class="scrolled ? \'fixed top-0 left-0 right-0 z-50 bg-[#0F2A44]/80 backdrop-blur-md py-3 shadow-lg\' : \'fixed top-0 left-0 right-0 z-50 pt-4 sm:pt-10 px-3 sm:px-4\'"
     class="transition-all duration-500 ease-in-out">',
     
    // WhatsApp Floating Button
    'class="flex items-center justify-center w-14 h-14 bg-[#25D366] hover:bg-[#20b85a] text-white rounded-full shadow-[0_4px_20px_rgba(37,211,102,0.4)] transition-all duration-300 transform hover:scale-110 group relative"' =>
    'class="flex items-center justify-center w-14 h-14 bg-[#25D366] hover:bg-[#20b85a] text-white rounded-full shadow-[0_4px_20px_rgba(37,211,102,0.4)] transition-all duration-300 transform hover:scale-110 group relative animate-pulse"',
    
    // Meta / SEO / OpenGraph
    '<title>RooterIn - Diskon 25% Khusus Hari Ini &amp; Garansi 1 Tahun!</title>
<meta property="og:title" content="RooterIn - Diskon 25% Khusus Hari Ini &amp; Garansi 1 Tahun!">' =>
    '<title>RooterIn - Jasa Saluran Mampet & Pipa Cleaning Premium</title>
    <meta name="description" content="RooterIn menyediakan jasa saluran mampet profesional, pembersihan pipa, cuci toren, dan instalasi sanitary tanpa proses bongkar dan bergaransi 30 hari.">
    <meta property="og:title" content="RooterIn - Jasa Saluran Mampet & Pipa Cleaning Premium">
    <meta property="og:description" content="Mengatasi pipa mampet, wastafel tersumbat, dan saluran pembuangan air kotor secara tuntas tanpa membongkar pipa Anda. Hubungi teknisi kami 24 jam!">
    <meta property="og:image" content="images/logo.png">
    <meta property="og:url" content="https://rafaelabimanyu.github.io/rooterin/">
    <meta property="og:type" content="website">',

    '<title>RooterIn - Diskon 25% Khusus Hari Ini & Garansi 1 Tahun!</title>
<meta property="og:title" content="RooterIn - Diskon 25% Khusus Hari Ini &amp; Garansi 1 Tahun!">' =>
    '<title>RooterIn - Jasa Saluran Mampet & Pipa Cleaning Premium</title>
    <meta name="description" content="RooterIn menyediakan jasa saluran mampet profesional, pembersihan pipa, cuci toren, dan instalasi sanitary tanpa proses bongkar dan bergaransi 30 hari.">
    <meta property="og:title" content="RooterIn - Jasa Saluran Mampet & Pipa Cleaning Premium">
    <meta property="og:description" content="Mengatasi pipa mampet, wastafel tersumbat, dan saluran pembuangan air kotor secara tuntas tanpa membongkar pipa Anda. Hubungi teknisi kami 24 jam!">
    <meta property="og:image" content="images/logo.png">
    <meta property="og:url" content="https://rafaelabimanyu.github.io/rooterin/">
    <meta property="og:type" content="website">',
];

foreach ($files as $file) {
    echo "Processing file: " . basename($file) . "\n";
    $content = file_get_contents($file);
    
    // Apply common replacements
    foreach ($commonReplacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    // File-specific modifications
    if (basename($file) === 'index.html') {
        // Hero Image path and alt
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&amp;fit=crop&amp;q=80&amp;w=1200" alt="Technician" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">',
            '<img src="images/pages/hero1.webp" alt="Teknisi Rooterin melakukan inspeksi pipa menggunakan drain camera" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">',
            $content
        );
        
        // Mid solution main image path and alt
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1542013936693-884638332954?w=1200&amp;fit=crop" class="w-full transition-transform duration-1000 group-hover:scale-105" alt="Feature Main">',
            '<img src="images/pages/home/solution_main.webp" class="w-full transition-transform duration-1000 group-hover:scale-105" alt="Layanan Rooterin mengatasi saluran pipa mampet tanpa bongkar">',
            $content
        );
        
        // Mid solution sub image path, alt, and size constraints
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&amp;fit=crop" alt="Feature Secondary" class="w-full h-full object-cover">',
            '<img src="images/pages/home/solution_sub.webp" alt="Pembersihan saluran pipa mampet menggunakan alat modern oleh teknisi Rooterin" class="w-full h-full object-cover">',
            $content
        );
        
        // Change width wrapper of sub image from absolute coordinates to w-48 sm:w-52
        $content = str_replace(
            'class="absolute -bottom-6 sm:-bottom-10 -right-6 sm:-right-10 w-48 sm:w-52 z-20 rounded-[1.5rem] sm:rounded-[2rem] overflow-hidden shadow-2xl border-4 sm:border-8 border-white group animate-bounce-soft"',
            'class="absolute -bottom-6 sm:-bottom-10 -right-6 sm:-right-10 w-48 sm:w-52 z-20 rounded-[1.5rem] sm:rounded-[2rem] overflow-hidden shadow-2xl border-4 sm:border-8 border-white group animate-bounce-soft"', // Keep/ensure correct size classes
            $content
        );

        // Section Solusi Tengah grid heading h4 to h3
        // Look for: <h4 class="font-black text-xl mb-2 transition-colors ...">...</h4>
        $content = preg_replace(
            '/<h4 class="font-black text-xl mb-2 transition-colors([^"]*)">([^<]*)<\/h4>/',
            '<h3 class="font-black text-xl mb-2 transition-colors$1">$2</h3>',
            $content
        );
        
        // Section Jangkauan Wilayah subtitle typo
        $content = str_replace(
            '<span class="text-primary font-black tracking-[0.3em] uppercase text-[10px] sm:text-xs block mb-4 animate-fade-in-up">
            PENYINGGAH TERDEKAT
        </span>',
            '<span class="text-primary font-black tracking-[0.3em] uppercase text-[10px] sm:text-xs block mb-4 animate-fade-in-up">
            Area Jangkauan Terdekat
        </span>',
            $content
        );
        
        // Section Jangkauan Wilayah card hover classes
        $content = str_replace(
            'class="group relative bg-white border border-gray-100 rounded-[2.5rem] p-6 flex items-center gap-6 shadow-xl shadow-gray-100/50 hover:shadow-2xl hover:shadow-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all duration-500"',
            'class="group relative bg-white border border-gray-100 rounded-[2.5rem] p-6 flex items-center gap-6 shadow-xl shadow-gray-100/50 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-2xl hover:border-[#1FAF5A]/50"',
            $content
        );
        
        // Section Jangkauan Wilayah card heading h4 to h3
        $content = str_replace(
            '<h4 class="text-secondary font-black text-xl tracking-tight leading-none mb-1">',
            '<h3 class="text-secondary font-black text-xl tracking-tight leading-none mb-1">',
            $content
        );
        $content = str_replace(
            '</h4>' . "\n" . '                        <div class="flex items-center gap-2">',
            '</h3>' . "\n" . '                        <div class="flex items-center gap-2">',
            $content
        );
        
        // Section Jangkauan Wilayah card image paths & alt tags
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=600&amp;fit=crop" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="JABODETABEK">',
            '<img src="images/pages/home/region/jabodetabek.png" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="Tim teknisi Rooterin melayani area JABODETABEK dan sekitarnya">',
            $content
        );
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1504148455328-c376907d081c?w=600&amp;fit=crop" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="CIREBON">',
            '<img src="images/pages/home/region/cirebon.png" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="Tim teknisi Rooterin melayani area CIREBON dan sekitarnya">',
            $content
        );
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=600&amp;fit=crop" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="SEMARANG">',
            '<img src="images/pages/home/region/semarang.png" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="Tim teknisi Rooterin melayani area SEMARANG dan sekitarnya">',
            $content
        );
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=600&amp;fit=crop" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="YOGYAKARTA">',
            '<img src="images/pages/home/region/yogyakarta.png" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="Tim teknisi Rooterin melayani area YOGYAKARTA dan sekitarnya">',
            $content
        );
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1590602847861-f357a9332bbc?w=600&amp;fit=crop" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="LAMPUNG">',
            '<img src="images/pages/home/region/lampung.png" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="Tim teknisi Rooterin melayani area LAMPUNG dan sekitarnya">',
            $content
        );
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1542013936693-884638332954?w=600&amp;fit=crop" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="METRO">',
            '<img src="images/pages/home/region/metro.png" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="Tim teknisi Rooterin melayani area METRO dan sekitarnya">',
            $content
        );

        // Corporate B2B Banner: Replace the 3 overlapping avatar images with SVG
        $content = str_replace(
            '<div class="flex -space-x-4">
                                            <div class="relative group/avatar">
                                                <img src="https://i.pravatar.cc/100?u=tech1" class="relative w-16 h-16 rounded-full border-[6px] border-secondary shadow-2xl object-cover transition-transform duration-500 group-hover/avatar:scale-110" alt="Expert">
                                            </div>
                                            <div class="relative group/avatar">
                                                <img src="https://i.pravatar.cc/100?u=tech2" class="relative w-16 h-16 rounded-full border-[6px] border-secondary shadow-2xl object-cover transition-transform duration-500 group-hover/avatar:scale-110" alt="Expert">
                                            </div>
                                            <div class="relative group/avatar">
                                                <img src="https://i.pravatar.cc/100?u=tech3" class="relative w-16 h-16 rounded-full border-[6px] border-secondary shadow-2xl object-cover transition-transform duration-500 group-hover/avatar:scale-110" alt="Expert">
                                            </div>
                                    </div>',
            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 text-[#1FAF5A]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 16.5h1.5m3 0H15" />
                                    </svg>',
            $content
        );
        
        // CTA Section Bawah title & heading class adjustments
        $content = str_replace(
            '<h2 class="text-3xl sm:text-5xl lg:text-7xl font-heading font-black text-white leading-[1.1] mb-8 sm:mb-12">
                    Saluran Pipa Masih Mampet? <br> <span class="text-accent italic">Plong-kan Sekarang!</span>
                </h2>',
            '<h2 class="text-3xl sm:text-4xl lg:text-5xl font-heading font-black text-white leading-[1.1] mb-8 sm:mb-12">
                    Saluran Pipa Masih Mampet? <br class="hidden md:inline"> <span class="text-accent italic">Plong-kan Sekarang!</span>
                </h2>',
            $content
        );
        $content = str_replace(
            'Saluran Pipa Masih Mampet? <br> <span class="text-accent italic">Plong-kan Sekarang!</span>',
            'Saluran Pipa Masih Mampet? <br class="hidden md:inline"> <span class="text-accent italic">Plong-kan Sekarang!</span>',
            $content
        );
        
        // Services cards transition class modifications
        $content = str_replace(
            'class="group relative flex flex-col bg-white rounded-[3.5rem] p-10 sm:p-12 border border-gray-100 hover:border-primary/20 transition-all duration-700 h-full hover:-translate-y-3 hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.15)] overflow-hidden"',
            'class="group relative flex flex-col bg-white rounded-[3.5rem] p-10 sm:p-12 border border-gray-100 h-full overflow-hidden transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-2xl hover:border-[#1FAF5A]/50"',
            $content
        );
        $content = str_replace(
            'alt="Service Preview"',
            'alt="Layanan Rooterin profesional"',
            $content
        );
        
        // FAQ Accordion Height transition
        // Find: <div \n                            x-show="activeFaq === index" \n                            x-collapse \n                            x-cloak \n                        >
        $content = preg_replace(
            '/<div \s+ x-show="activeFaq === (\d+|\w+)" \s+ x-collapse \s+ x-cloak \s*>/x',
            '<div class="transition-all duration-500 ease-in-out overflow-hidden" :class="activeFaq === $1 ? \'max-h-[500px] opacity-100\' : \'max-h-0 opacity-0\'" x-cloak>',
            $content
        );
    }
    
    if (basename($file) === 'galeri.html') {
        // Slanted hero gallery images
        $content = str_replace(
            'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=600&fit=crop',
            'images/pages/hero1.webp',
            $content
        );
        $content = str_replace(
            'https://images.unsplash.com/photo-1542013936693-884638332954?w=600&fit=crop',
            'images/pages/hero2.webp',
            $content
        );
        
        // x-transition added to template items
        $content = str_replace(
            'class="group relative cursor-pointer"',
            'x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="group relative cursor-pointer"',
            $content
        );
        
        // h4 to h3 inside gallery
        $content = str_replace(
            '<h4 class="text-white text-2xl font-heading font-black leading-tight tracking-tight mb-2 group-hover:text-primary transition-colors" x-text="item.title"></h4>',
            '<h3 class="text-white text-2xl font-heading font-black leading-tight tracking-tight mb-2 group-hover:text-primary transition-colors" x-text="item.title"></h3>',
            $content
        );
    }
    
    if (basename($file) === 'about.html') {
        // Verified expert image
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1542013936693-884638332954?q=80&amp;w=1200&amp;auto=format&amp;fit=crop"',
            '<img src="images/team/team.png"',
            $content
        );
        $content = str_replace(
            '<img src="https://images.unsplash.com/photo-1542013936693-884638332954?q=80&w=1200&auto=format&fit=crop"',
            '<img src="images/team/team.png"',
            $content
        );
    }
    
    if (basename($file) === 'layanan.html') {
        // Services cards transition class modifications
        $content = str_replace(
            'class="group relative flex flex-col bg-white rounded-[3.5rem] p-10 sm:p-12 border border-gray-100 hover:border-primary/20 transition-all duration-700 h-full hover:-translate-y-3 hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.15)] overflow-hidden"',
            'class="group relative flex flex-col bg-white rounded-[3.5rem] p-10 sm:p-12 border border-gray-100 h-full overflow-hidden transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-2xl hover:border-[#1FAF5A]/50"',
            $content
        );
    }
    
    file_put_contents($file, $content);
}

echo "All files synced successfully!\n";
