<?php

namespace App\Models;

use App\Enums\PrisonerStatus;
use App\Enums\SecurityLevel;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prisoner extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'prisoner_id',
        'first_name',
        'last_name',
        'nationality',
        'height',
        'weight',
        'date_of_birth',
        'sex',
        'admission_date',
        'release_date',
        'cell_block',
        'cell_number',
        'status',
        'status_note',
        'security_level',
        'medical_conditions',
        'current_medications',
        'emergency_contact',
        'emergency_phone',
        'relationship',
        'photo_path',
    ];

    public function crimes()
    {
        return $this->belongsToMany(Crime::class, 'crime_prisoner')
            ->withPivot('committed_date', 'additional_notes')
            ->withTimestamps();
    }

    public function medicalRecords()
    {
        return $this->hasMany(PrisonerMedicalRecord::class);
    }

    public function paroles()
    {
        return $this->hasMany(PrisonerParole::class);
    }

    public function escapePrisoner()
    {
        return $this->hasOne(EscapePrisoner::class, 'prisoner_id');
    }

    public function diseasePrisoner()
    {
        return $this->hasOne(DiseasePrisoner::class, 'prisoner_id');
    }

    public function transfferedPrisoner()
    {
        return $this->hasOne(TransfferedPrisoner::class, 'prisoner_id');
    }

    public function releasedPrisoner()
    {
        return $this->hasOne(ReleasePrisoner::class, 'prisoner_id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'release_date' => 'date',
        'height' => 'decimal:1',
        'weight' => 'decimal:1',
        'status' => PrisonerStatus::class,
        'security_level' => SecurityLevel::class,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'deleted_at',
    ];

    /**
     * Get the full name of the prisoner
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function generateDefaultPrisonerId(): string
    {
        // Include soft-deleted records in the query
        $lastPrisoner = Prisoner::withTrashed()->orderBy('id', 'desc')->first();
    
        // Check if there's at least one record
        if ($lastPrisoner) {
            // Extract the number from the last generated ID
            preg_match('/P-\d{4}-(\d+)/', $lastPrisoner->prisoner_id, $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0; // Default to 0 if no match
        } else {
            // If no records exist, start from 1
            $lastNumber = 0;
        }
    
        // Increment the number
        $newNumber = $lastNumber + 1;
    
        // Generate the new prisoner ID (Prefix + Year + Incremented Number)
        $this->prisoner_id = 'P-' . date('Y') . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    
        return "{$this->prisoner_id}";
    }
    
    



    /**
     * Check if prisoner is active
     */
    public function isActive(): bool
    {
        return $this->status === PrisonerStatus::ACTIVE;
    }

    /**
     * Check if prisoner needs special security measures
     */
    public function isHighRisk(): bool
    {
        return in_array($this->security_level, [
            SecurityLevel::MAXIMUM,
            SecurityLevel::SUPERMAX
        ]);
    }

    /**
     * Scope query to only include active prisoners
     */
    public function scopeActive($query)
    {
        return $query->where('status', PrisonerStatus::ACTIVE->value);
    }

    /**
     * Scope query to filter by security level
     */
    public function scopeSecurityLevel($query, SecurityLevel $level)
    {
        return $query->where('security_level', $level->value);
    }

    /**
     * Get prisoners by cell block
     */
    public function scopeInCellBlock($query, $cellBlock)
    {
        return $query->where('cell_block', $cellBlock);
    }

    /**
     * Get the age of the prisoner
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    /**
     * Check if prisoner has medical conditions
     */
    public function hasMedicalConditions(): bool
    {
        return !empty($this->medical_conditions);
    }

    /**
     * Get remaining sentence time
     */
    public function getRemainingTimeAttribute()
    {
        if (!$this->release_date) {
            return null;
        }

        return now()->diff($this->release_date);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
    
        // Auto-generate prisoner_id if not set
        static::creating(function ($prisoner) {
            if (!$prisoner->prisoner_id) {
                // Include soft-deleted records in the count
                $maxId = static::withTrashed()->max('id') ?? 0;
    
                // Generate a new prisoner_id based on the max ID
                $prisoner->prisoner_id = 'P' . date('Y') . str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);
            }
        });
    }
    

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status->getLabel();
    }

    /**
     * Get security level label
     */
    public function getSecurityLevelLabelAttribute(): string
    {
        return $this->security_level->getLabel();
    }

    /**
     * Attach a crime with logging.
     *
     * @param int $crimeId
     * @param array $pivotData
     * @return void
     */

    public function attachCrimeWithLogging(int $crimeId, array $pivotData = [])
    {
        $this->crimes()->attach($crimeId, $pivotData);

        $properties = [
            'old' => [], // No previous values for 'attached' event
            'attributes' => [
                'crime_id' => $crimeId,
                'committed_date' => $pivotData['committed_date'] ?? null,
                'additional_notes' => $pivotData['additional_notes'] ?? null,
            ],
        ];
        // Log the activity
        activity()
            ->performedOn($this)
            ->causedBy(Auth::user())
            ->withProperties($properties)
            ->event('attached')
            ->log("Assigned Crime ID {$crimeId} to Prisoner ID {$this->id}");
    }
}
