<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiseasePrisoner extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'prisoner_id',
        'death_date',
        'death_cause',
    ];

    protected $casts = [
        'death_date' => 'date',
    ];

    public function prisoner()
    {
        return $this->belongsTo(Prisoner::class);
    }
}
