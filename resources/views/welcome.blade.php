{{-- 
    ARCHITECTURE OVERVIEW:
    This landing page follows a High-Level Modular System.
    - SECTIONS: Located in components/sections/, these are top-level containers for page logic.
    - PARTS: Located in components/parts/ or core components/, these are reusable atomic/molecular elements.
    - DATA FLOW: All content data is defined here or in a config file and passed via props to maintain SRP.
--}}
@php
    $servicesData = [
        [
            'title' => 'Saluran Pembuangan',
            'tagline' => 'TEKNOLOGI TANPA BONGKAR',
            'desc' => 'Solusi tuntas WC & pipa mampet dengan mesin Spiral Baja. Menghancurkan sumbatan kerak lemak tanpa merusak konstruksi.',
            'img' => 'https://images.unsplash.com/photo-1585955123058-930415956a69?w=800&fit=crop',
            'color' => 'primary'
        ],
        [
            'title' => 'Air Bersih & Toren',
            'tagline' => 'HIGIENIS & BEBAS LUMUT',
            'desc' => 'Normalisasi kran mampet & cuci tangki air. Teknik sterilisasi pipa untuk menjamin aliran air bersih yang sehat & lancar.',
            'img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop',
            'color' => 'accent'
        ],
        [
            'title' => 'Instalasi Sanitary',
            'tagline' => 'TEKNIK PRESISI TINGGI',
            'desc' => 'Pemasangan kran, kloset, & jalur pipa baru. Dikerjakan dengan standar profesional untuk hasil rapi, kuat, & permanen.',
            'img' => 'https://images.unsplash.com/photo-1541123437800-1bb1317badc2?w=800&fit=crop',
            'color' => 'secondary'
        ]
    ];
@endphp

<x-app-layout title="Jasa Saluran Mampet & Pipe Cleaning Premium">
    
    {{-- 1. Hero Section - Primary Entry Point --}}
    <x-sections.hero />

    {{-- 2. Trust Banner - Unique Selling Propositions --}}
    <x-sections.trust-banner />

    {{-- 3. Features Section - Problem Solver Explanation --}}
    <x-sections.features />

    {{-- 4. Mega CTA - Urgent Problem Engagement --}}
    <x-sections.cta-mega />

    {{-- 5. Services Section - Detailed Solutions Offering --}}
    <x-sections.services :services="$servicesData" />

    {{-- 6. Gallery Section - Visual Proof of Completion --}}
    <x-sections.gallery :items="[
        ['img' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80', 'title' => 'Pipa Dapur Mampet', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&q=80', 'title' => 'Saluran Air Kamar Mandi', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1521207418485-99c705420785?w=800&q=80', 'title' => 'Wastafel Kantor', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800&q=80', 'title' => 'Pengerjaan Rooter Spiral', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&q=80', 'title' => 'Pipa Mampet Gedung', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1585955123058-930415956a69?w=800&q=80', 'title' => 'Wastafel Kembali Lancar', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&q=80', 'title' => 'Alat Modern Terbaru', 'category' => 'Specialized'],
        ['img' => 'https://images.unsplash.com/photo-1538474705339-e51de814eaa3?w=800&q=80', 'title' => 'Kerja Tim Profesional', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1541123437800-1bb1317badc2?w=800&q=80', 'title' => 'Bongkar Kerak Lemak', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1581244276891-6bc617f77bc7?w=800&q=80', 'title' => 'Inspeksi Pipa Endoscope', 'category' => 'Specialized'],
        ['img' => 'https://images.unsplash.com/photo-1605667332750-b828e3550775?w=800&q=80', 'title' => 'Pipa Toilet Lancar', 'category' => 'Residential'],
    ]" />

    {{-- 7. Coverage Section - Location Presence --}}
    <x-sections.coverage />

    {{-- Floating/Sticky Components --}}
    <x-sticky-footer />

</x-app-layout>
