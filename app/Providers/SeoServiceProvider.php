<?php

namespace App\Providers;

use App\Models\SeoSetting;
use App\Services\Seo\SemanticSchemaBuilder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema as LaravelSchema;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\View;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SemanticSchemaBuilder::class, function ($app) {
            return new SemanticSchemaBuilder();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(SemanticSchemaBuilder $schemaBuilder): void
    {
        if (!LaravelSchema::hasTable('seo_settings')) {
            return;
        }

        $settings = SeoSetting::all()->pluck('value', 'key');

        if ($settings->isNotEmpty()) {
            $siteName = $settings->get('site_name', config('app.name'));
            $urgency = $settings->get('market_urgency', '');
            
            // "Competitor Sniffer": Auto-inject urgency to boost CTR
            $displaySiteName = $urgency ? "$siteName - $urgency" : $siteName;

            config([
                'seotools.meta.defaults.title'       => $displaySiteName,
                'seotools.meta.defaults.description' => $settings->get('meta_description', ''),
                'seotools.meta.defaults.separator'   => $settings->get('title_separator', '|'),
                
                'seotools.opengraph.defaults.title'       => $displaySiteName,
                'seotools.opengraph.defaults.description' => $settings->get('meta_description', ''),
                'seotools.opengraph.defaults.site_name'   => $siteName,
            ]);

            // Entity-based Semantic Graph Generation
            $graph = $schemaBuilder->buildGraph(['settings' => $settings]);
            $jsonLd = "";
            foreach($graph as $entity) {
                $jsonLd .= $entity->toScript() . "\n";
            }
            
            View::share('semanticSchema', $jsonLd);
            
            // Automatic Hreflang Injection
            View::share('hreflangTags', $schemaBuilder->generateHreflangs());
        }
    }
}
