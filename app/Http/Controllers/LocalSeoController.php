<?php

namespace App\Http\Controllers;

use App\Models\SeoCity;
use App\Models\Service;
use App\Models\LocalizedReview;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class LocalSeoController extends Controller
{
    /**
     * Tampilkan halaman layanan spesifik di kota tertentu.
     */
    public function show(string $citySlug, string $serviceSlug)
    {
        $city = SeoCity::where('slug', $citySlug)->where('is_active', true)->firstOrFail();
        $service = Service::where('slug', $serviceSlug)->firstOrFail();

        // Trust Architect: Pull localized reviews for this city
        $cityReviews = LocalizedReview::where('seo_city_id', $city->id)->where('is_active', true)->get();
        if ($cityReviews->isEmpty()) {
            $cityReviews = LocalizedReview::whereNull('seo_city_id')->where('is_active', true)->take(3)->get();
        }

        // Semantic Keyword Cloud (LSI)
        $lsiCloud = $city->lsi_keywords ? array_map('trim', explode(',', $city->lsi_keywords)) : [];

        // SEO Magic: Hyper-Localized Content
        $title = "{$service->name} di {$city->name} - Pipa Mampet Beres!";
        $description = "Cari {$service->name} di {$city->name}? Rooterin hadir dengan layanan profesional di wilayah {$city->name} dan sekitarnya. Terbukti amanah & bergaransi.";

        SEOTools::setTitle($title);
        SEOTools::setDescription($description);

        return view('local-seo.service-city', compact('city', 'service', 'cityReviews', 'lsiCloud'));
    }

    /**
     * Tampilkan landing page utama untuk kota tertentu.
     */
    public function cityLanding(string $citySlug)
    {
        $city = SeoCity::where('slug', $citySlug)->where('is_active', true)->firstOrFail();
        $services = Service::where('is_active', true)->get();
        
        $cityReviews = LocalizedReview::where('seo_city_id', $city->id)->where('is_active', true)->get();
        if ($cityReviews->isEmpty()) {
            $cityReviews = LocalizedReview::whereNull('seo_city_id')->where('is_active', true)->take(3)->get();
        }

        $lsiCloud = $city->lsi_keywords ? array_map('trim', explode(',', $city->lsi_keywords)) : [];

        $title = "Jasa Pipa Mampet & Rooterin Terbaik di {$city->name}";
        $description = "Solusi mampet nomor 1 di {$city->name}. Kami melayani seluruh area {$city->name} dengan peralatan modern.";

        SEOTools::setTitle($title);
        SEOTools::setDescription($description);

        return view('local-seo.city-index', compact('city', 'services', 'cityReviews', 'lsiCloud'));
    }
}
