<?php

namespace App\Models;

use App\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crime extends BaseModel 
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['crime_name'];

    public function prisoners()
    {
        return $this->belongsToMany(Prisoner::class, 'crime_prisoner')->withPivot('committed_date', 'additional_notes')->withTimestamps();
    }
}
