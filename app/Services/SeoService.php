<?php 



namespace App\Services;

use App\Models\Seo;
use Illuminate\Support\Facades\Route;

class SeoService
{
    public function getSeoData(): ?Seo
    {
        $route = Route::currentRouteName();
        $slug = trim(request()->path(), '/');

        return Seo::where('page', $route)
                ->orWhere('page', $slug)
                ->first();
    }
        public function forProductPage($product)
    {
        return [
            'meta_title' => $product->name,
            'meta_description' => str($product->description)->limit(160),
            'meta_keywords' => $product->tags ?? 'product, buy, ecommerce',
            'canonical_url' => url()->current(),
            'og_title' => $product->name,
            'og_image' => $product->image_url ?? null,
            'twitter_title' => $product->name,
            'twitter_image' => $product->image_url ?? null,
        ];
    }
}