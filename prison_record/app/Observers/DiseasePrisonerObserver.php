<?php

namespace App\Observers;

use App\Enums\PrisonerStatus;
use App\Models\Prisoner;

class DiseasePrisonerObserver
{
    /**
     * Handle the Prisoner "created" event.
     */
    public function created(Prisoner $prisoner)
    {
        if ($prisoner->status->value === PrisonerStatus::DECEASED->value) {
            try {
                $prisoner->diseasePrisoner()->create([
                    'death_date' => now(),
                    'death_cause' => $prisoner->status_note ?? 'No notes provided',
                ]);
            } catch (\Exception $e) {
                debugbar()->info('Error creating escape record: ' . $e->getMessage());
            }
        } else {
            debugbar()->info('Prisoner status is not "escaped". No escape record created.');
        }
    }

    /**
     * Handle the Prisoner "updated" event.
     */
    public function updated(Prisoner $prisoner)
    {
        if ($prisoner->status->value === PrisonerStatus::DECEASED->value) { // Compare using the enum's value
            try {
                // Check if a deleted escape record exists
                $existingDiseaseRecord = $prisoner->diseasePrisoner()->withTrashed()->first();

                if ($existingDiseaseRecord && $existingDiseaseRecord->trashed()) {
                    // Restore the deleted record
                    $existingDiseaseRecord->restore();
                    $existingDiseaseRecord->update([
                        'death_date' => now(),
                        'death_cause' => $prisoner->status_note ?? 'No notes provided',
                    ]);
                } else {
                    // Create or update the escape record
                    $prisoner->diseasePrisoner()->updateOrCreate(
                        [],
                        [
                            'death_date' => now(),
                            'death_cause' => $prisoner->status_note ?? 'No notes provided',
                        ]
                    );
                }
            } catch (\Exception $e) {
                debugbar()->info('Error updating/creating/restoring escape record: ' . $e->getMessage());
            }
        } else {
            debugbar()->info('Prisoner status is not "escaped". Attempting to delete escape record.');

            try {
                $prisoner->diseasePrisoner()->delete();
                debugbar()->info('Escape record deleted successfully.');
            } catch (\Exception $e) {
               debugbar()->info('Error deleting escape record: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle the Prisoner "deleted" event.
     */
    public function deleted(Prisoner $prisoner): void
    {
        if ($prisoner->status->value === PrisonerStatus::DECEASED->value) {
            try {
                $prisoner->diseasePrisoner()->delete();
                debugbar()->info('Disease record deleted successfully with prisoner deletion.');
            } catch (\Exception $e) {
                debugbar()->info('Error deleting disease record during prisoner deletion: ' . $e->getMessage());
            }
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
