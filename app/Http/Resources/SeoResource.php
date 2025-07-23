<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'page'              => $this->page,
            'meta_title'        => $this->meta_title,
            'meta_description'  => $this->meta_description,
            'meta_keywords'     => $this->meta_keywords,
            'og_title'          => $this->og_title,
            'og_image'          => $this->og_image,
            'canonical_url'     => $this->canonical_url,
            'robots'            => $this->robots,
            'twitter_title'     => $this->twitter_title,
            'twitter_image'     => $this->twitter_image,
        ];
    }
}
