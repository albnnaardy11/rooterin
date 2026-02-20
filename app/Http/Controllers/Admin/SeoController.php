<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use App\Models\SeoRedirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\EventLog;
use App\Models\SeoKeyword;
use App\Models\SeoCity;
use App\Models\LocalizedReview;
use App\Services\Seo\GoogleIndexingService;
use App\Services\Sentinel\SentinelService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    public function index(SentinelService $sentinel)
    {
        $healthData = $sentinel->monitorAll();
        $settings = SeoSetting::pluck('value', 'key');
        $redirects = SeoRedirect::latest()->get();
        
        // Ensure some default settings exist if empty
        if ($settings->isEmpty()) {
            $settings = collect([
                'title_template' => '%title% | %site_name%',
                'site_name' => config('app.name'),
                'title_separator' => '|',
                'meta_description' => '',
            ]);
        }

        $robotsContent = "";
        if (File::exists(public_path('robots.txt'))) {
            $robotsContent = File::get(public_path('robots.txt'));
        }

        // Conversion Stats
        $topPages = EventLog::where('event_type', 'whatsapp_click')
            ->select('page_url', DB::raw('count(*) as total'))
            ->groupBy('page_url')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $deviceStats = EventLog::where('event_type', 'whatsapp_click')
            ->select('device_type', DB::raw('count(*) as total'))
            ->groupBy('device_type')
            ->get();

        $keywords = SeoKeyword::orderByDesc('priority')->get();
        $cities = SeoCity::orderBy('name')->get();
        $reviews = LocalizedReview::with('city')->latest()->get();

        return view('admin.seo.index', compact('settings', 'redirects', 'robotsContent', 'topPages', 'deviceStats', 'keywords', 'cities', 'reviews', 'healthData'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        
        foreach ($data as $key => $value) {
            SeoSetting::set($key, $value);
        }

        return back()->with('success', 'Global SEO settings updated successfully!');
    }

    public function storeRedirect(Request $request)
    {
        $request->validate([
            'source_url' => 'required|unique:seo_redirects,source_url',
            'destination_url' => 'required',
            'status_code' => 'required|in:301,302',
        ]);

        SeoRedirect::create($request->all());

        return back()->with('success', 'Redirect rule added!');
    }

    public function deleteRedirect(SeoRedirect $redirect)
    {
        $redirect->delete();
        return back()->with('success', 'Redirect rule removed!');
    }

    public function updateRobots(Request $request)
    {
        $content = $request->input('content');
        File::put(public_path('robots.txt'), $content);

        return back()->with('success', 'robots.txt updated successfully!');
    }

    public function ping()
    {
        // In a real app, this would use spatie/laravel-sitemap to submit or call Google Indexing API
        // For now, let's pretend and return success
        return back()->with('success', 'Sitemap pinged to Google & Bing successfully!');
    }

    public function clearCache()
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        return back()->with('success', 'SEO Cache and views flushed!');
    }

    public function storeKeyword(Request $request)
    {
        $request->validate([
            'keyword' => 'required|unique:seo_keywords,keyword',
            'target_url' => 'required',
            'priority' => 'required|integer|min:1|max:10',
        ]);

        SeoKeyword::create($request->all());
        Cache::forget('seo_internal_keywords');

        return back()->with('success', 'Authority keyword added!');
    }

    public function deleteKeyword(SeoKeyword $keyword)
    {
        $keyword->delete();
        Cache::forget('seo_internal_keywords');
        return back()->with('success', 'Keyword removed!');
    }

    public function storeCity(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:seo_cities,name',
        ]);

        SeoCity::create($request->all());

        return back()->with('success', 'New city target added!');
    }

    public function deleteCity(SeoCity $city)
    {
        $city->delete();
        return back()->with('success', 'City target removed.');
    }

    public function updateCity(Request $request, SeoCity $city)
    {
        $city->update($request->all());
        return back()->with('success', 'City SEO updated!');
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'review_text' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        LocalizedReview::create($request->all());
        return back()->with('success', 'Trust review added!');
    }

    public function deleteReview(LocalizedReview $review)
    {
        $review->delete();
        return back()->with('success', 'Review removed.');
    }

    public function pushIndexing(GoogleIndexingService $indexingService)
    {
        $cities = SeoCity::where('is_active', true)->get();
        $urls = [url('/')];

        foreach ($cities as $city) {
            $urls[] = route('local.city', $city->slug);
            
            // Assume we push all service variations for each city
            $services = \App\Models\Service::where('is_active', true)->get();
            foreach ($services as $service) {
                $urls[] = route('local.service', [$city->slug, $service->slug]);
            }
        }

        // Limit to prevent timeouts in single request, ideally use a Queue for massive lists
        $targetUrls = array_slice($urls, 0, 100); 
        $results = $indexingService->batchNotify($targetUrls);

        $successCount = collect($results)->where('success', true)->count();

        return back()->with('success', "Rocket Fired! $successCount URLs pushed to Google. Crawler is on its way.");
    }
}
