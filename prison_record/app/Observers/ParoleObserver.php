<?php

namespace App\Observers;

use App\Models\Prisoner;
use App\Models\PrisonerParole;
use Carbon\Carbon;

class ParoleObserver
{
    /**
     * Handle the PrisonerParole "created" event.
     */
    public function created(PrisonerParole $prisonerParole): void
    {
        $prisoner = $prisonerParole->prisoner;

        $currentReleaseDate = Carbon::parse($prisoner->release_date);

        $newReleaseDate = $currentReleaseDate->subYears($prisonerParole->sentence_reduction);

        $prisoner->update([
            'release_date' => $newReleaseDate,
        ]);
    }

    /**
     * Handle the PrisonerParole "updated" event.
     */
    public function updated(PrisonerParole $prisonerParole): void
    {
        if ($prisonerParole->wasChanged('prisoner_id')) {
            // Handle prisoner change
            $this->handlePrisonerChange($prisonerParole);
        } elseif ($prisonerParole->wasChanged('sentence_reduction')) {
            // Handle sentence reduction change
            $this->handleSentenceReductionChange($prisonerParole);
        }
    }

    /**
     * Handle changes when prisoner_id is modified.
     */
    private function handlePrisonerChange(PrisonerParole $prisonerParole): void
    {
        // Restore previous prisoner's original release date
        $oldPrisonerId = $prisonerParole->getOriginal('prisoner_id');
        $oldPrisoner = Prisoner::find($oldPrisonerId);

        if ($oldPrisoner) {
            $oldReduction = $prisonerParole->getOriginal('sentence_reduction');

            // Get original release date without reduction
            $originalReleaseDate = $this->getOriginalReleaseDate($oldPrisoner, $oldReduction);
            $oldPrisoner->update(['release_date' => $originalReleaseDate]);
        }

        // Apply reduction to new prisoner
        $newPrisoner = $prisonerParole->prisoner;
        if ($newPrisoner) {
            // Calculate new release date with reduction
            $newReleaseDate = Carbon::parse($newPrisoner->release_date)
                ->subYears($prisonerParole->sentence_reduction);
            $newPrisoner->update(['release_date' => $newReleaseDate]);
        }
    }

    /**
     * Handle changes when sentence_reduction is modified.
     */
    private function handleSentenceReductionChange(PrisonerParole $prisonerParole): void
    {
        $oldReduction = $prisonerParole->getOriginal('sentence_reduction');
        $newReduction = $prisonerParole->sentence_reduction;
        $prisoner = $prisonerParole->prisoner;

        if (!$prisoner) {
            return;
        }

        if ($newReduction != $oldReduction) {
            // First, get the original release date without any reductions
            $originalReleaseDate = $this->getOriginalReleaseDate($prisoner, $oldReduction);

            // Then apply the new reduction from the original date
            $newReleaseDate = Carbon::parse($originalReleaseDate)
                ->subYears($newReduction);

            $prisoner->update(['release_date' => $newReleaseDate]);
        }
    }

    /**
     * Calculate the original release date without any reductions
     */
    private function getOriginalReleaseDate(Prisoner $prisoner, int $currentReduction): string
    {
        return Carbon::parse($prisoner->release_date)
            ->addYears($currentReduction)
            ->toDateString();
    }


    /**
     * Handle the PrisonerParole "deleted" event.
     */
    public function deleted(PrisonerParole $prisonerParole): void
    {
        $prisoner = $prisonerParole->prisoner;
        $originalReleaseDate = Carbon::parse($prisoner->release_date)
            ->addYears($prisonerParole->sentence_reduction);

        $prisoner->update(['release_date' => $originalReleaseDate]);
    }

    /**
     * Handle the PrisonerParole "restored" event.
     */
    public function restored(PrisonerParole $prisonerParole): void
    {
        //
    }

    /**
     * Handle the PrisonerParole "force deleted" event.
     */
    public function forceDeleted(PrisonerParole $prisonerParole): void
    {
        //
    }
}
