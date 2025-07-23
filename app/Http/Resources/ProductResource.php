<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'discount_percentage' => $this->discount_percentage,
            'discounted_price' => $this->discounted_price,
            'images' => $this->images,
            'status' => $this->status,

            'details' => [
                'short_description' => optional($this->details)->short_description,
                'long_description' => optional($this->details)->long_description,
                'gender' => optional($this->details)->gender,
                'fragrance_type' => optional($this->details)->fragrance_type,
                'concentration' => optional($this->details)->concentration,
                'top_notes' => optional($this->details)->top_notes,
                'middle_notes' => optional($this->details)->middle_notes,
                'base_notes' => optional($this->details)->base_notes,
                'volume_ml' => optional($this->details)->volume_ml,
                'longevity_hours' => optional($this->details)->longevity_hours,
                'country_of_origin' => optional($this->details)->country_of_origin,
            ],

            'stock' => [
                'quantity' => optional($this->stock)->quantity ?? 0,
            ],

            'reviews' => $this->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'user_name' => $review->user_name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at->toDateTimeString(),
                ];
            }),
            'average_rating' => round($this->reviews->avg('rating'), 1),
            'review_count' => $this->reviews->count(),

            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
