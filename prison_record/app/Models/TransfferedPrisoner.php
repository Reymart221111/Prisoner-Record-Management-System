<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransfferedPrisoner extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'prisoner_id',
        'transfer_date',
        'notes',
    ];

    protected $casts = [
        'transfer_date' => 'date',
    ];

    public function prisoner()
    {
        return $this->belongsTo(Prisoner::class);
    }
}
