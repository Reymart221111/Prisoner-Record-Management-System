<?php

namespace App\Observers;

use App\Enums\PrisonerStatus;
use App\Models\Prisoner;
use Barryvdh\Debugbar\Facades\Debugbar as FacadesDebugbar;


class EscapePrisonerObserver
{
    /**
     * Handle the Prisoner "created" event.
     */
    public function created(Prisoner $prisoner)
    {
        FacadesDebugbar::info('Prisoner created observer triggered', ['prisoner_id' => $prisoner->id]);

        if ($prisoner->status->value === PrisonerStatus::ESCAPED->value) {
            FacadesDebugbar::info('Prisoner status is "escaped"', ['status' => $prisoner->status]);

            try {
                $prisoner->escapePrisoner()->create([
                    'escape_date' => now(),
                    'notes' => $prisoner->status_note ?? 'No notes provided',
                ]);

                FacadesDebugbar::success('Escape record created successfully.');
            } catch (\Exception $e) {
                FacadesDebugbar::error('Error creating escape record: ' . $e->getMessage());
            }
        } else {
            FacadesDebugbar::info('Prisoner status is not "escaped". No escape record created.');
        }
    }

    /**
     * Handle the Prisoner "updated" event.
     */
    public function updated(Prisoner $prisoner)
    {
        FacadesDebugbar::info('Prisoner updated observer triggered', ['prisoner_id' => $prisoner->id]);
        FacadesDebugbar::info('Prisoner status:', ['prisoner_status' => $prisoner->status]);

        if ($prisoner->status->value === PrisonerStatus::ESCAPED->value) { // Compare using the enum's value
            FacadesDebugbar::info('Prisoner status updated to "escaped"', ['status' => $prisoner->status->value]);

            try {
                // Check if a deleted escape record exists
                $existingEscapeRecord = $prisoner->escapePrisoner()->withTrashed()->first();

                if ($existingEscapeRecord && $existingEscapeRecord->trashed()) {
                    // Restore the deleted record
                    $existingEscapeRecord->restore();
                    $existingEscapeRecord->update([
                        'escape_date' => now(),
                        'notes' => $prisoner->status_note ?? 'No notes provided',
                    ]);
                    FacadesDebugbar::log('Escape record restored and updated successfully.');
                } else {
                    // Create or update the escape record
                    $prisoner->escapePrisoner()->updateOrCreate(
                        [],
                        [
                            'escape_date' => now(),
                            'notes' => $prisoner->status_note ?? 'No notes provided',
                        ]
                    );
                    FacadesDebugbar::success('Escape record updated or created successfully.');
                }
            } catch (\Exception $e) {
                FacadesDebugbar::log('Error updating/creating/restoring escape record: ' . $e->getMessage());
            }
        } else {
            FacadesDebugbar::info('Prisoner status is not "escaped". Attempting to delete escape record.');

            try {
                $prisoner->escapePrisoner()->delete();
                FacadesDebugbar::success('Escape record deleted successfully.');
            } catch (\Exception $e) {
                FacadesDebugbar::error('Error deleting escape record: ' . $e->getMessage());
            }
        }
    }



    /**
     * Handle the Prisoner "deleted" event.
     */
    public function deleted(Prisoner $prisoner): void
    {
        if ($prisoner->status->value === PrisonerStatus::ESCAPED->value) {
            try {
                $prisoner->escapePrisoner()->delete();
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
        FacadesDebugbar::info('Prisoner restored observer triggered', ['prisoner_id' => $prisoner->id]);
    }

    /**
     * Handle the Prisoner "force deleted" event.
     */
    public function forceDeleted(Prisoner $prisoner): void
    {
        FacadesDebugbar::info('Prisoner force deleted observer triggered', ['prisoner_id' => $prisoner->id]);
    }
}
