<?php

namespace App\Observers;

use App\Models\Ad;
use App\Services\AdService;
use Illuminate\Support\Facades\Log;

class AdObserver
{
    /**
     * Handle the Ad "created" event.
     */
    public function created(Ad $ad): void
    {
        $this->clearAdCache();
        
        Log::info('Ad created', [
            'ad_id' => $ad->id,
            'ad_title' => $ad->title,
            'is_active' => $ad->is_active,
        ]);
    }

    /**
     * Handle the Ad "updated" event.
     */
    public function updated(Ad $ad): void
    {
        $this->clearAdCache();
        
        // Log status changes
        if ($ad->wasChanged('is_active')) {
            Log::info('Ad status changed', [
                'ad_id' => $ad->id,
                'ad_title' => $ad->title,
                'old_status' => $ad->getOriginal('is_active') ? 'active' : 'inactive',
                'new_status' => $ad->is_active ? 'active' : 'inactive',
            ]);
        }

        // Log expiration changes
        if ($ad->wasChanged('expires_at')) {
            Log::info('Ad expiration changed', [
                'ad_id' => $ad->id,
                'ad_title' => $ad->title,
                'old_expires_at' => $ad->getOriginal('expires_at'),
                'new_expires_at' => $ad->expires_at,
            ]);
        }
    }

    /**
     * Handle the Ad "deleted" event.
     */
    public function deleted(Ad $ad): void
    {
        $this->clearAdCache();
        
        Log::info('Ad deleted', [
            'ad_id' => $ad->id,
            'ad_title' => $ad->title,
        ]);
    }

    /**
     * Handle the Ad "restored" event.
     */
    public function restored(Ad $ad): void
    {
        $this->clearAdCache();
        
        Log::info('Ad restored', [
            'ad_id' => $ad->id,
            'ad_title' => $ad->title,
        ]);
    }

    /**
     * Handle the Ad "force deleted" event.
     */
    public function forceDeleted(Ad $ad): void
    {
        $this->clearAdCache();
        
        Log::info('Ad permanently deleted', [
            'ad_id' => $ad->id,
            'ad_title' => $ad->title,
        ]);
    }

    /**
     * Clear ad cache using the service
     */
    private function clearAdCache(): void
    {
        try {
            app(AdService::class)->clearCache();
        } catch (\Exception $e) {
            Log::error('Failed to clear ad cache in observer', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}