<?php

namespace App\Observers;

use App\Models\Prisoner;
use App\Enums\PrisonerStatus;

class TransfferedPrisonerObserver
{
    /**
     * Handle the Prisoner "created" event.
     */
    public function created(Prisoner $prisoner)
    {
        if ($prisoner->status->value === PrisonerStatus::TRANSFERRED->value) {
            try {
                $prisoner->transfferedPrisoner()->create([
                    'transfer_date' => now(),
                    'notes' => $prisoner->status_note ?? 'No notes provided',
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
        if ($prisoner->status->value === PrisonerStatus::TRANSFERRED->value) { // Compare using the enum's value
            try {
                // Check if a deleted escape record exists
                $existingRecord = $prisoner->transfferedPrisoner()->withTrashed()->first();

                if ($existingRecord && $existingRecord->trashed()) {
                    // Restore the deleted record
                    $existingRecord->restore();
                    $existingRecord->update([
                        'transfer_date' => now(),
                        'notes' => $prisoner->status_note ?? 'No notes provided',
                    ]);
                } else {
                    // Create or update the escape record
                    $prisoner->transfferedPrisoner()->updateOrCreate(
                        [],
                        [
                            'transfer_date' => now(),
                            'notes' => $prisoner->status_note ?? 'No notes provided',
                        ]
                    );
                }
            } catch (\Exception $e) {
                debugbar()->info('Error updating/creating/restoring escape record: ' . $e->getMessage());
            }
        } else {
            debugbar()->info('Prisoner status is not "escaped". Attempting to delete escape record.');

            try {
                $prisoner->transfferedPrisoner()->delete();
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
        if ($prisoner->status->value === PrisonerStatus::TRANSFERRED->value) {
            try {
                $prisoner->transfferedPrisoner()->delete();
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
