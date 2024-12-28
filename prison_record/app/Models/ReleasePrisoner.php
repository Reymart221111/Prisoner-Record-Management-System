<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReleasePrisoner extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'prisoner_id',
        'release_date',
        'notes',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function prisoner()
    {
        return $this->belongsTo(Prisoner::class);
    }
}
