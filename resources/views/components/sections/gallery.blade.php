@props([
    'title' => 'Galeri Hasil Kerja Nyata',
    'subtitle' => 'DOKUMENTASI LAPANGAN',
    'items' => [
        ['img' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&fit=crop', 'title' => 'Pipa Dapur Mampet', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop', 'title' => 'Saluran Air Kamar Mandi', 'category' => 'Apartment'],
        ['img' => 'https://images.unsplash.com/photo-1521207418485-99c705420785?w=800&fit=crop', 'title' => 'Wastafel Kantor', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800&fit=crop', 'title' => 'Pengerjaan Rooter Spiral', 'category' => 'Specialized']
    ]
])

<section id="gallery" {{ $attributes->merge(['class' => 'py-32 bg-stone-50 overflow-hidden']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 mb-20">
            <div class="max-w-2xl">
                <x-section-heading :title="$title" :subtitle="$subtitle" align="left" />
            </div>
            <div class="flex gap-4 scroll-m-20">
                <x-button variant="outline" class="!rounded-full px-6">Terbaru</x-button>
                <x-button variant="ghost" class="!rounded-full px-6">Residential</x-button>
                <x-button variant="ghost" class="!rounded-full px-6">Commercial</x-button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($items as $item)
                <x-gallery-item 
                    title="{{ $item['title'] }}" 
                    category="{{ $item['category'] }}" 
                    image="{{ $item['img'] }}" 
                />
            @endforeach
        </div>
    </div>
</section>
