<?php

namespace App\Events;

use App\Models\Offer;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferStatusUpdated
{
    use Dispatchable, SerializesModels;

    public $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }
}
