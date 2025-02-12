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
    public function saving(Prisoner $prisoner): void
    {
        if (!$prisoner->isActive()) {
            return;
        }

        $today = Carbon::now();

        if ($prisoner->release_date && Carbon::parse($prisoner->release_date)->toDateString() <= $today->toDateString()) {
            if ($prisoner->status->value !== PrisonerStatus::RELEASED->value) {
                $prisoner->status = PrisonerStatus::RELEASED;
                $prisoner->status_note = 'Automatically released due to completed sentence';
            }
        }
    }
    
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
        if ($prisoner->status->value === PrisonerStatus::RELEASED->value) {
            $this->handleReleasePrisoner($prisoner);
        }
    }

    public function deleted(Prisoner $prisoner): void
    {

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
