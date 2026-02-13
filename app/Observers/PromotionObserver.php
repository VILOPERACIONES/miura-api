<?php

namespace App\Observers;

use App\Models\Promotion;
use Illuminate\Support\Facades\Storage;

class PromotionObserver
{
    /**
     * Handle the Promotion "created" event.
     */
    public function created(Promotion $promotion): void
    {
        //
    }

    /**
     * Handle the Promotion "updated" event.
     */
    public function updated(Promotion $promotion): void
    {
        //
    }

    /**
     * Handle the Promotion "deleted" event.
     */
    public function deleted(Promotion $promotion): void
    {
        if ($promotion->image_desktop) {
            Storage::disk('public')->delete($promotion->image_desktop);
        }

        if ($promotion->image_mobile) {
            Storage::disk('public')->delete($promotion->image_mobile);
        }
    }

    /**
     * Handle the Promotion "restored" event.
     */
    public function restored(Promotion $promotion): void
    {
        //
    }

    /**
     * Handle the Promotion "force deleted" event.
     */
    public function forceDeleted(Promotion $promotion): void
    {
        //
    }
}
