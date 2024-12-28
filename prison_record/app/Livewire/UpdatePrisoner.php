<?php

namespace App\Livewire;

use App\Enums\PrisonerStatus;
use App\Enums\SecurityLevel;
use App\Enums\Sex;
use App\Models\Prisoner;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\Enum;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UpdatePrisoner extends Component
{
    use WithFileUploads;

    // Form Properties
    public $id;
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
    public $existing_photo_path;

    protected function rules()
    {
        return [
            'prisoner_id' => [
                'sometimes',
                Rule::unique('prisoners', 'prisoner_id')->ignore($this->id, 'id'),
            ],
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'required|string|min:2|max:50',
            'nationality' => 'required|string|max:50',
            'height' => 'required|numeric|between:100,250',
            'weight' => 'required|numeric|between:30,200',
            'date_of_birth' => [
                'required',
                'date',
                'before:today',
                function ($attribute, $value, $fail) {
                    $age = Carbon::parse($value)->age;
                    if ($age < 18) {
                        $fail('Prisoner must be at least 18 years old.');
                    }
                }
            ],
            'sex' => ['required', new Enum(Sex::class)],
            'admission_date' => 'required|date|before_or_equal:today',
            'release_date' => ['nullable', 'date', 'after:admission_date',  Rule::requiredIf(function () {
                // Log the current status value using debugbar
                Debugbar::info("Current Status: {$this->status->value}");

                $isRequired = in_array($this->status->value, [
                    PrisonerStatus::RELEASED->value,
                ]);

                // Log whether the status_note field should be required
                Debugbar::info("Is 'release_date' required? " . ($isRequired ? 'Yes' : 'No'));

                return $isRequired;
            })],
            'cell_block' => 'required|string|max:10',
            'cell_number' => 'required|string|max:10',
            'status' => [
                'required',
                new Enum(PrisonerStatus::class),
                function ($attribute, $value, $fail) {
                    if ($value === PrisonerStatus::RELEASED->value) {
                        if (!$this->release_date) {
                            $fail('You cannot select "Released" status without specifying a release date.');
                        }

                        if ($this->release_date) {
                            $releaseDate = Carbon::parse($this->release_date);

                            if ($releaseDate->lessThan(Carbon::parse($this->admission_date))) {
                                $fail('The release date cannot be before the admission date.');
                            }

                            if ($releaseDate->isFuture()) {
                                $fail('The release date cannot be in the future for a released prisoner.');
                            }
                        }
                    }
                }
            ],
            'status_note' => [
                'nullable',
                'string',
                Rule::requiredIf(function () {
                    // Log the current status value using debugbar
                    Debugbar::info("Current Status: {$this->status->value}");

                    $isRequired = in_array($this->status->value, [
                        PrisonerStatus::TRANSFERRED->value,
                        PrisonerStatus::RELEASED->value,
                        PrisonerStatus::DECEASED->value,
                        PrisonerStatus::ESCAPED->value,
                    ]);

                    // Log whether the status_note field should be required
                    Debugbar::info("Is 'status_note' required? " . ($isRequired ? 'Yes' : 'No'));

                    return $isRequired;
                })
            ],

            'security_level' => ['required', new Enum(SecurityLevel::class)],
            'medical_conditions' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:100',
            'emergency_phone' => 'nullable|string|max:20',
            'relationship' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ];
    }

    public function mount($prisonerId)
    {
        // Fetch the prisoner and perform authorization check
        $prisoner = Prisoner::findOrFail($prisonerId);

        if (!Auth::user()->can('update', $prisoner)) {
            abort(403, 'Unauthorized');
        }

        // Initialize form fields with existing prisoner data
        $this->id = $prisoner->id;
        $this->prisoner_id = $prisoner->prisoner_id;
        $this->first_name = $prisoner->first_name;
        $this->last_name = $prisoner->last_name;
        $this->nationality = $prisoner->nationality;
        $this->height = $prisoner->height;
        $this->weight = $prisoner->weight;
        $this->date_of_birth = optional($prisoner->date_of_birth)->format('Y-m-d');
        $this->sex = $prisoner->sex;
        $this->admission_date = optional($prisoner->admission_date)->format('Y-m-d');
        $this->release_date = optional($prisoner->release_date)->format('Y-m-d');
        $this->cell_block = $prisoner->cell_block;
        $this->cell_number = $prisoner->cell_number;
        $this->status = $prisoner->status;
        $this->status_note = $prisoner->status_note;
        $this->security_level = $prisoner->security_level;
        $this->medical_conditions = $prisoner->medical_conditions;
        $this->current_medications = $prisoner->current_medications;
        $this->emergency_contact = $prisoner->emergency_contact;
        $this->emergency_phone = $prisoner->emergency_phone;
        $this->relationship = $prisoner->relationship;
        $this->existing_photo_path = $prisoner->photo_path;
    }

    // Real-time validation
    public function updated($propertyName)
    {
        debugbar()->info([
            'method' => 'updated() called',
            'property_changed' => $propertyName,
            'current_status' => $this->status,
            'current_release_date' => $this->release_date,
            'validation_starting' => true
        ]);

        switch ($propertyName) {
            case 'status':
                $statusValue = $this->status instanceof PrisonerStatus ? $this->status->value : $this->status;

                debugbar()->info([
                    'status_validation' => 'triggered',
                    'status_value' => $statusValue,
                    'released_value' => PrisonerStatus::RELEASED->value,
                    'is_equal' => $statusValue === PrisonerStatus::RELEASED->value
                ]);

                if ($statusValue === PrisonerStatus::RELEASED->value) {
                    debugbar()->info('Checking Released status requirements');

                    if (!$this->release_date) {
                        debugbar()->info('Release date missing - adding error');
                        $this->addError('status', 'You cannot select "Released" status without specifying a release date.');
                        break;
                    }

                    if ($this->release_date && Carbon::parse($this->release_date)->isFuture()) {
                        debugbar()->info('The release date cannot be in the future for a released prisoner.');
                        $this->addError('status', 'The release date cannot be in the future for a released prisoner.');
                        break;
                    }

                    debugbar()->info('Attempting to validate Released status with release date');
                    $this->validate([
                        'status' => $this->rules()['status'],
                        'release_date' => $this->rules()['release_date']
                    ]);
                } else {
                    debugbar()->info('Validating non-Released status');
                    $this->validateOnly('status');
                }
                break;

            case 'release_date':
                $statusValue = $this->status instanceof PrisonerStatus ? $this->status->value : $this->status;

                debugbar()->info([
                    'release_date_validation' => 'triggered',
                    'new_release_date' => $this->release_date,
                    'status_value' => $statusValue
                ]);

                if ($statusValue === PrisonerStatus::RELEASED->value) {
                    debugbar()->info('Validating release date with Released status');
                    $this->validate([
                        'status' => $this->rules()['status'],
                        'release_date' => $this->rules()['release_date']
                    ]);
                } else {
                    debugbar()->info('Validating release date only');
                    $this->validateOnly('release_date');
                }
                break;

            default:
                debugbar()->info([
                    'other_field_validation' => 'triggered',
                    'field' => $propertyName
                ]);
                $this->validateOnly($propertyName);
                break;
        }

        debugbar()->info([
            'validation_completed' => true,
            'final_status' => $this->status,
            'final_release_date' => $this->release_date
        ]);
    }


    protected $messages = [
        'release_date.required' => 'the released date is required if you select a prisoner for releasing',
    ];


    public function updatePrisoner()
    {
        // Fetch prisoner for authorization check
        $prisoner = Prisoner::findOrFail($this->id);

        if (!Auth::user()->can('update', $prisoner)) {
            abort(403, 'Unauthorized');
        }

        $validatedData = $this->validate();

        if (
            $this->status === PrisonerStatus::RELEASED->value &&
            (!$this->release_date || Carbon::parse($this->release_date)->lessThan(Carbon::parse($this->admission_date)))
        ) {
            $this->addError('release_date', 'Invalid release date for the selected status.');
            return;
        }

        try {
            // Handle photo upload with image processing
            if ($this->photo) {
                $filename = 'prisoner-' . time() . '.' . $this->photo->getClientOriginalExtension();

                // Create new ImageManager instance
                $manager = new ImageManager(new Driver()); // Using GD as the driver

                // Read image from path
                $img = $manager->read($this->photo->getRealPath());

                // Resize image
                $img->resize(900, 900, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $path = 'uploads/prisoner-photos/';
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }

                // Save the processed image
                Storage::disk('public')->put(
                    $path . $filename,
                    $img->toJpeg()->toString()
                );

                // Add photo path to validated data
                $validatedData['photo_path'] = $path . $filename;

                // Delete old photo if it exists
                if ($prisoner->photo_path && Storage::disk('public')->exists($prisoner->photo_path)) {
                    Storage::disk('public')->delete($prisoner->photo_path);
                }
            }

            // Remove 'photo' from validated data since it's a file, not directly a model attribute
            unset($validatedData['photo']);

            // Update prisoner record
            $prisoner->update($validatedData);

            session()->flash('success', 'Prisoner record updated successfully.');
            if (Auth::user()->role === 'superadmin') {
                return redirect()->route('superadmin.prisoners.show', $prisoner->id);
            }
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.prisoners.show', $prisoner->id);
            }
            if (Auth::user()->role === 'employee') {
                return redirect()->route('employee.prisoners.show', $prisoner->id);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating prisoner record: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $statusOptions = PrisonerStatus::cases();
        $securityLevelOptions = SecurityLevel::cases();
        $sexOptions = Sex::cases();

        return view('livewire.update-prisoner', compact('statusOptions', 'securityLevelOptions', 'sexOptions'));
    }
}
