<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Prisoner;
use App\Enums\PrisonerStatus;
use App\Enums\SecurityLevel;
use App\Enums\Sex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreatePrisonerForm extends Component
{
    use WithFileUploads;

    public $prisoner_id;
    public $first_name;
    public $last_name;
    public $nationality;
    public $height;
    public $weight;
    public $date_of_birth;
    public $sex;
    public $admission_date;
    public $release_date;
    public $cell_block;
    public $cell_number;
    public $status;
    public $status_note;
    public $security_level;
    public $medical_conditions;
    public $current_medications;
    public $emergency_contact;
    public $emergency_phone;
    public $relationship;
    public $photo;

    public $statusOptions = [];
    public $securityLevelOptions = [];
    public $validationErrors = [];

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'nationality' => 'required|string|max:255',
        'height' => 'required|numeric|min:0|max:300',
        'weight' => 'required|numeric|min:0|max:500',
        'date_of_birth' => 'required|date|before:today',
        'sex' => 'required|enum:' . Sex::class,
        'admission_date' => 'required|date',
        'release_date' => 'nullable|date|after:admission_date',
        'cell_block' => 'required|string|max:50',
        'cell_number' => 'required|string|max:50',
        'status' => 'required|enum:' . PrisonerStatus::class,
        'status_note' => 'required_if:status,transferred,released,deceased',
        'security_level' => 'required|enum:' . SecurityLevel::class,
        'medical_conditions' => 'nullable|string',
        'current_medications' => 'nullable|string',
        'emergency_contact' => 'nullable|string|max:255',
        'emergency_phone' => 'nullable|string|max:20',
        'relationship' => 'nullable|string|max:100',
        'photo' => 'nullable|image|max:2048', // Max 2MB
    ];

    public function mount()
    {
        // Authorization check based on the PrisonerPolicy
        if (!Auth::user()->can('create', Prisoner::class)) {
            abort(403, 'Unauthorized');
        }

        // Retrieve available options for status and security levels from enums
        $this->statusOptions = PrisonerStatus::cases();
        $this->securityLevelOptions = SecurityLevel::cases();
    }

    protected function getValidationAttributes()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'nationality' => 'Nationality',
            'height' => 'Height',
            'weight' => 'Weight',
            'date_of_birth' => 'Date of Birth',
            'sex' => 'Sex',
            'admission_date' => 'Admission Date',
            'release_date' => 'Release Date',
            'cell_block' => 'Cell Block',
            'cell_number' => 'Cell Number',
            'status' => 'Status',
            'status_note' => 'Status Note',
            'security_level' => 'Security Level',
        ];
    }

    public function updated($propertyName)
    {
        // Validate the specific field that was updated
        $this->validateOnly($propertyName);
    }

    public function savePrisoner()
    {
        // Full validation before saving
        $validatedData = $this->validate();

        //pOLICIES CHECK
        if (!Auth::user()->can('create', Prisoner::class)) {
            abort(403, 'Unauthorized');
        }

        try {
            // Generate a unique ID if not provided
            $this->prisoner_id = $this->prisoner_id ?? 'P' . now()->format('Y') . str_pad(Prisoner::count() + 1, 4, '0', STR_PAD_LEFT);

            // Handle photo upload if a file is provided
            $photoPath = null;
            if ($this->photo) {
                $photoName = "{$this->prisoner_id}_" . time() . '.' . $this->photo->getClientOriginalExtension();
                $photoPath = $this->photo->storeAs('public/uploads/prisoner-images', $photoName);
            }

            // Create the prisoner record
            Prisoner::create([
                'prisoner_id' => $this->prisoner_id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'nationality' => $this->nationality,
                'height' => $this->height,
                'weight' => $this->weight,
                'date_of_birth' => $this->date_of_birth,
                'sex' => $this->sex,
                'admission_date' => $this->admission_date,
                'release_date' => $this->release_date,
                'cell_block' => $this->cell_block,
                'cell_number' => $this->cell_number,
                'status' => $this->status,
                'status_note' => $this->status_note,
                'security_level' => $this->security_level,
                'medical_conditions' => $this->medical_conditions,
                'current_medications' => $this->current_medications,
                'emergency_contact' => $this->emergency_contact,
                'emergency_phone' => $this->emergency_phone,
                'relationship' => $this->relationship,
                'photo_path' => $photoPath ? Storage::url($photoPath) : null,
            ]);

            // Clear all form inputs after successful submission
            $this->reset([
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
                'photo'
            ]);

            $this->dispatchBrowserEvent('flash-message', [
                'type' => 'success',
                'message' => 'Prisoner record created successfully.'
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('flash-message', [
                'type' => 'error',
                'message' => 'An error occurred while creating the prisoner record.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.create-prisoner-form');
    }
}
