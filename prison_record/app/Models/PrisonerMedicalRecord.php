<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrisonerMedicalRecord extends BaseModel
{
    use SoftDeletes;


    protected $fillable = [
        'prisoner_id',
        'medical_diagnosis',  // Changed here too
        'medication',
        'last_checkup_date',
        'doctor_notes'
    ];

    public function prisoner()
    {
        return $this->belongsTo(Prisoner::class);
    }
}
