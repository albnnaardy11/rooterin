<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Static URLs --}}
    @foreach ($staticUrls as $url)
        <url>
            <loc>{{ $url }}</loc>
            <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- Posts / Tips --}}
    @foreach ($posts as $post)
        <url>
            <loc>{{ route('tips.detail', $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    {{-- Wikis --}}
    @foreach ($wikis as $wiki)
        <url>
            <loc>{{ route('wiki.detail', $wiki->slug) }}</loc>
            <lastmod>{{ $wiki->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach

    {{-- Cities --}}
    @foreach ($cities as $city)
        <url>
            <loc>{{ route('local.city', $city->slug) }}</loc>
            <lastmod>{{ $city->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach

    {{-- City Services --}}
    @foreach ($cityServices as $cs)
        <url>
            <loc>{{ route('local.service', ['city' => $cs['city_slug'], 'service' => $cs['service_slug']]) }}</loc>
            <lastmod>{{ $cs['updated_at']->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
