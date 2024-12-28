<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CrimePrisoner extends Pivot
{
    use LogsActivity;

    protected $table = 'crime_prisoner';

    protected $guarded = [];

    public $timestamps = true;

    /**
     * Configure the activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['crime_id', 'prisoner_id', 'assigned_at', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return match ($eventName) {
                    'created' => "Created pivot record between Crime ID {$this->crime_id} and Prisoner ID {$this->prisoner_id}",
                    'updated' => "Updated pivot record between Crime ID {$this->crime_id} and Prisoner ID {$this->prisoner_id}",
                    'deleted' => "Deleted pivot record between Crime ID {$this->crime_id} and Prisoner ID {$this->prisoner_id}",
                    default => "Pivot record {$eventName} between Crime ID {$this->crime_id} and Prisoner ID {$this->prisoner_id}",
                };
            })
            ->useLogName('audit');
    }
}
