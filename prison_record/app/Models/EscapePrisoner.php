<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EscapePrisoner extends BaseModel
{
    use SoftDeletes;
    
    protected $fillable = [
        'prisoner_id',
        'escape_date',
        'notes',
    ];

    protected $casts = [
        'escape_date' => 'date',
    ];

    public function prisoner()
    {
        return $this->belongsTo(Prisoner::class);
    }
}
