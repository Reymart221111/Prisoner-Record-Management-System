<?php

namespace App\Models;

use App\Enums\ParoleStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrisonerParole extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'prisoner_id',
        'parole_type',
        'sentence_reduction',
    ];

    protected $casts = [
        'parole_type' => ParoleStatus::class
    ];

    // PrisonerParole.php
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($parole) {
            $prisoner = $parole->prisoner;
            $releaseDate = Carbon::parse($prisoner->release_date);
            $admissionDate = Carbon::parse($prisoner->admission_date);

            // Calculate total sentence length
            $totalDays = abs($releaseDate->diffInDays($admissionDate));
            $totalYears = round($totalDays / 365.25, 2); // Round to 2 decimal places for precision

            // If this is an update, add back the original reduction before validation
            if ($parole->exists) {
                $originalReduction = $parole->getOriginal('sentence_reduction') ?? 0;
                $totalYears += $originalReduction;
            }

            if ($parole->sentence_reduction > $totalYears) {
                throw new \Exception(
                    "Sentence reduction ({$parole->sentence_reduction} years) cannot exceed total sentence length ({$totalYears} years)."
                );
            }

            return true;
        });
    }

    public function prisoner()
    {
        return $this->belongsTo(Prisoner::class);
    }
}
