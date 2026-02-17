@php
    $galleryItems = [
        ['img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop', 'title' => 'Pipa Dapur Mampet', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&fit=crop', 'title' => 'Saluran Air Kamar Mandi', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1521207418485-99c705420785?w=800&fit=crop', 'title' => 'Wastafel Kantor', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800&fit=crop', 'title' => 'Pengerjaan Rooter Spiral', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&fit=crop', 'title' => 'Pipa Mampet Gedung', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1525909002-1b05e0c869d8?w=800&fit=crop', 'title' => 'Wastafel Kembali Lancar', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&fit=crop', 'title' => 'Alat Modern Terbaru', 'category' => 'Specialized'],
        ['img' => 'https://images.unsplash.com/photo-1531973576160-7125cd663d86?w=800&fit=crop', 'title' => 'Kerja Tim Profesional', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1599661046289-e318878567c4?w=800&fit=crop', 'title' => 'Bongkar Kerak Lemak', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1581244276891-6bc617f77bc7?w=800&fit=crop', 'title' => 'Inspeksi Pipa Endoscope', 'category' => 'Specialized'],
    ];
@endphp

<x-app-layout title="Galeri Kerja - Portofolio Jasa Saluran Mampet">
    
    {{-- 1. Unique Gallery Hero --}}
    <x-sections.gallery.hero />

    {{-- 2. New Unique Portfolio Showcase (Custom for this page) --}}
    <x-sections.gallery.portfolio :items="$galleryItems" />

    {{-- 3. Final Engagement --}}
    <x-sections.tentang.cta />

</x-app-layout>
