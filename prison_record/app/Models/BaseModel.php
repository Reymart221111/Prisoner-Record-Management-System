<?php

namespace App\Models;

use App\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

abstract class BaseModel extends Model
{
    use LogsActivity, Auditable;

    // protected static function booted()
    // {
    //     static::created(function ($model) {
    //         activity('audit')
    //             ->performedOn($model)
    //             ->causedBy(Auth::user())
    //             ->withProperties(['custom' => 'data'])
    //             ->log("A new record was created in {$model->getTable()}");
    //     });
    // }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()             // Log all attributes
            ->logOnlyDirty()       // Only log changed attributes
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "{$this->getTable()} with Id: {$this->id} has been {$eventName}")
            ->useLogName('audit');
    }

    // Optional: Add a method to get specific attributes to log for each model
    protected function getAttributesToLog(): array
    {
        return $this->fillable;
    }
}
