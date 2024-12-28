<?php

namespace App\Observers;

use App\Enums\PrisonerStatus;
use App\Models\Prisoner;
use App\Models\ReleasePrisoner;
use Carbon\Carbon;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

use function PHPUnit\Framework\throwException;

class ReleasePrisonerObserver
{
    // public function updating(Prisoner $prisoner): void
    // {
    //     // Check if prisoner was active before the update
    //     $wasActive = $prisoner->getOriginal('status') === PrisonerStatus::ACTIVE->value;

    //     if (!$wasActive && !$prisoner->isActive()) {
    //         return;
    //     }

    //     $today = Carbon::now()->startOfDay();

    //     // Auto release based on date
    //     if ($prisoner->release_date && Carbon::parse($prisoner->release_date)->startOfDay()->lte($today)) {
    //         $prisoner->status = PrisonerStatus::RELEASED;
    //         $prisoner->status_note = 'Automatically released due to completed sentence';
    //         $this->handleReleasePrisoner($prisoner);
    //     }

    //     // Handle status changes
    //     if ($prisoner->isDirty('status')) {
    //         if ($prisoner->status->value === PrisonerStatus::RELEASED->value) {
    //             $this->handleReleasePrisoner($prisoner);
    //         } else {
    //             // If status changed to something other than RELEASED, soft delete the release record
    //             $prisoner->releasedPrisoner()->delete();
    //         }
    //     }
    // }

    // public function saving(Prisoner $prisoner): void
    // {
    //     if (!$prisoner->isActive()) {
    //         return;
    //     }

    //     $today = Carbon::now()->startOfDay();

    //     if ($prisoner->release_date && Carbon::parse($prisoner->release_date)->startOfDay()->lte($today)) {
    //         $prisoner->status = PrisonerStatus::RELEASED;
    //         $prisoner->status_note = 'Automatically released due to completed sentence';
    //         $this->handleReleasePrisoner($prisoner);
    //     }
    // }

    // public function saving(Prisoner $prisoner)
    // {
    //     if ($prisoner->status->value === PrisonerStatus::RELEASED->value) {
    //         // Check for existing record including soft-deleted ones
    //         $existingRecord = $prisoner->releasedPrisoner()->withTrashed()->first();
            
    //         if ($existingRecord) {
    //             // If record exists but was deleted, restore it
    //             if ($existingRecord->trashed()) {
    //                 $existingRecord->restore();
    //                 $existingRecord->update([
    //                     'release_date' => $prisoner->release_date,
    //                     'notes' => 'Automatically Release due to completed sentence.',
    //                 ]);
    //             }
    //         } else {
    //             // Create new record if none exists at all
    //             $prisoner->releasedPrisoner()->create([
    //                 'release_date' => $prisoner->release_date,
    //                 'notes' => 'Automatically Release due to completed sentence.',
    //             ]);
    //         }
    //         debugbar()->info('Save to releases successfully!');
    //     }
    // }

    public function updated(Prisoner $prisoner)
    {
        // Get the original status before the update
        $originalStatus = $prisoner->getOriginal('status')->value;
        $newStatus = $prisoner->status->value;
    
        // If the prisoner was already released and still is, ignore the update
        if ($originalStatus === PrisonerStatus::RELEASED->value && 
            $newStatus === PrisonerStatus::RELEASED->value) {
            return;
        }
    
        if ($newStatus === PrisonerStatus::RELEASED->value) {
            try {
                // Get the specific release record for this prisoner
                $existingRecord = $prisoner->releasedPrisoner()->withTrashed()->first();
    
                if ($existingRecord) {
                    if ($existingRecord->trashed()) {
                        $existingRecord->restore();
                    }
    
                    $existingRecord->update([
                        'released_date' => $prisoner->release_date,
                        'notes' => $prisoner->status_note ?? 'Released Due to completed Sentence',
                    ]);
                } else {
                    // Create new record if none exists
                    $prisoner->releasedPrisoner()->create([
                        'released_date' => $prisoner->release_date,
                        'notes' => $prisoner->status_note ?? 'Released Due to completed Sentence',
                    ]);
                }
            } catch (\Throwable $th) {
                throw new Exception('Error: ' . $th->getMessage());
            }
        } else {
            // If status is not RELEASED, soft delete the release record
            $prisoner->releasedPrisoner()->delete();
        }
    }


    private function handleReleasePrisoner(Prisoner $prisoner): void
    {
        debugbar()->info('Handling prisoner release', [
            'prisoner_id' => $prisoner->prisoner_id,
            'status' => $prisoner->status,
            'release_date' => $prisoner->release_date
        ]);

        try {
            $releaseRecord = ReleasePrisoner::withTrashed()
                ->updateOrCreate(
                    ['prisoner_id' => $prisoner->id], // Add the primary key condition
                    [
                        'release_date' => $prisoner->release_date ?? now(),
                        'notes' => $prisoner->status_note,
                        'deleted_at' => null
                    ]
                );

            debugbar()->info('Release record created/updated:', [
                'release_record' => $releaseRecord->toArray()
            ]);
        } catch (\Exception $e) {
            debugbar()->error('Error creating release record:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function created(Prisoner $prisoner): void
    {
        if (!$prisoner->isActive()) {
            return;
        }

        if ($prisoner->status->value === PrisonerStatus::RELEASED->value) {
            $this->handleReleasePrisoner($prisoner);
        }
    }

    public function deleted(Prisoner $prisoner): void
    {
        if (!$prisoner->isActive()) {
            return;
        }

        $prisoner->releasedPrisoner()->delete();
    }

    public function restored(Prisoner $prisoner): void
    {
        if (!$prisoner->isActive()) {
            return;
        }

        if ($prisoner->status->value === PrisonerStatus::RELEASED->value) {
            $prisoner->releasedPrisoner()->withTrashed()->restore();
        }
    }

    public function forceDeleted(Prisoner $prisoner): void
    {
        if (!$prisoner->isActive()) {
            return;
        }

        $prisoner->releasedPrisoner()->forceDelete();
    }
}
