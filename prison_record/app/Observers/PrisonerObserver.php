<?php

namespace App\Observers;

use App\Enums\PrisonerStatus;
use App\Models\Prisoner;
use Barryvdh\Debugbar\Facades\Debugbar;

class PrisonerObserver
{
    /**
     * Handle the Prisoner "created" event.
     */
    public function created(Prisoner $prisoner): void
    {
        //
    }

    /**
     * Handle the Prisoner "updated" event.
     */
    public function updated(Prisoner $prisoner)
    {
        // 
    }


    /**
     * Handle the Prisoner "deleted" event.
     */
    public function deleted(Prisoner $prisoner): void
    {
        // Check if this is a soft delete
        if ($prisoner->isForceDeleting()) {
            // Hard delete associated parole records
            $prisoner->paroles()->forceDelete();
        } else {
            // Soft delete associated parole records
            $prisoner->paroles()->delete();
        }
    }

    /**
     * Handle the Prisoner "restored" event.
     */
    public function restored(Prisoner $prisoner): void
    {
        //
    }

    /**
     * Handle the Prisoner "force deleted" event.
     */
    public function forceDeleted(Prisoner $prisoner): void
    {
        //
    }
}
