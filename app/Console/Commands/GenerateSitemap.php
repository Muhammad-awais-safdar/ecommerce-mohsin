<?php

namespace App\Console\Commands;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Console\Command;
use App\Models\Product; 
use App\Models\Seo; // The Seo model we just created
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // Static Pages from SEO table
        $pages = Seo::pluck('page'); // Assuming 'page' stores routes like '/', '/about', etc.
        foreach ($pages as $page) {
            $sitemap->add(Url::create($page));
        }

        // Product Pages
        foreach (Product::all() as $product) {
            $sitemap->add(Url::create(route('product.show', $product->id)));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }

}