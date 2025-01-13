<?php

namespace App\Livewire;

use App\Enums\PrisonerStatus;
use App\Enums\SecurityLevel;
use App\Enums\Sex;
use App\Models\Prisoner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\Enum;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class StorePrisoner extends Component
{
    use WithFileUploads;

    // Form Properties
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

    protected function rules()
    {
        return [
            'prisoner_id' => 'sometimes|unique:prisoners,prisoner_id',
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
            'release_date' => 'nullable|date|after:admission_date',
            'cell_block' => 'required|string|max:40',
            'cell_number' => 'required|string|max:10',
            'status' => [
                'required',
                new Enum(PrisonerStatus::class),
                function ($attribute, $value, $fail) {
                    if ($value === PrisonerStatus::RELEASED->value) {
                        if (empty($this->release_date)) {
                            $fail('Cannot set status to Released without a release date.');
                        } else {
                            $releaseDate = Carbon::parse($this->release_date)->startOfDay();
                            $today = Carbon::now()->startOfDay();

                            if ($releaseDate->gt($today)) {
                                $fail('Cannot set status to Released before the release date.');
                            }
                        }
                    }
                }
            ],
            'status_note' => [
                'nullable',
                'string',
                Rule::requiredIf(
                    fn() =>
                    in_array($this->status, [
                        PrisonerStatus::TRANSFERRED->value,
                        PrisonerStatus::RELEASED->value,
                        PrisonerStatus::DECEASED->value
                    ])
                )
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

    protected $messages = [
        'height.between' => 'Height must be between 100cm and 250cm.',
        'weight.between' => 'Weight must be between 30kg and 200kg.',
        'photo.max' => 'Photo must not be larger than 2MB.',
    ];

    // Real-time validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        // Set default values
        $this->admission_date = now()->format('Y-m-d');
        $this->status = PrisonerStatus::ACTIVE->value;
        $this->security_level = SecurityLevel::MINIMUM->value;
        $generatePrisonerId = new Prisoner();
        $this->prisoner_id = $generatePrisonerId->generateDefaultPrisonerId();
    }

    public function resetForm()
    {
        // Reset all form properties
        $this->prisoner_id = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->nationality = null;
        $this->height = null;
        $this->weight = null;
        $this->date_of_birth = null;
        $this->sex = null;
        $this->admission_date = now()->format('Y-m-d');
        $this->release_date = null;
        $this->cell_block = null;
        $this->cell_number = null;
        $this->status = PrisonerStatus::ACTIVE->value;
        $this->status_note = null;
        $this->security_level = SecurityLevel::MINIMUM->value;
        $this->medical_conditions = null;
        $this->current_medications = null;
        $this->emergency_contact = null;
        $this->emergency_phone = null;
        $this->relationship = null;
        $this->photo = null;

        // Dispatch an event to reset Alpine.js state
        $this->dispatch('form-reset');
    }

    public function savePrisoner()
    {
        $validatedData = $this->validate();

        if (empty($validatedData['release_date'])) {
            $validatedData['release_date'] = null;
        }
        
        try {
            // Start transaction with SERIALIZABLE isolation level
            \DB::statement('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
            \DB::beginTransaction();
         

            // Handle photo upload with image processing
            if ($this->photo) {
                $filename = 'prisoner-' . time() . '.' . $this->photo->getClientOriginalExtension();

                // Create new ImageManager instance
                $manager = new ImageManager(new Driver());

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

                $validatedData['photo_path'] = $path . $filename;
            }

            // Remove photo from validated data as it's not in the model
            unset($validatedData['photo']);

            // If updating an existing prisoner, handle old photo deletion
            if (isset($this->prisoner_id)) {
                $prisoner = Prisoner::find($this->prisoner_id);
                if ($prisoner && $prisoner->photo_path && Storage::disk('public')->exists($prisoner->photo_path)) {
                    Storage::disk('public')->delete($prisoner->photo_path);
                }
            }

            // Create prisoner record
            $prisoner = Prisoner::create($validatedData);

            // Commit transaction
            \DB::commit();

            session()->flash('success', 'Prisoner record added successfully.');

            // Redirect to the newly created prisoner's view
            if (Auth::user()->role === 'superadmin') {
                return redirect()->route('superadmin.prisoners.show', $prisoner->id);
            } elseif (Auth::user()->role === 'admin') {
                return redirect()->route('admin.prisoners.show', $prisoner->id);
            } elseif (Auth::user()->role === 'employee') {
                return redirect()->route('employee.prisoners.show', $prisoner->id);
            }
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            \DB::rollBack();
            session()->flash('error', 'Error creating prisoner record: ' . $e->getMessage());
        }
    }


    public function render()
    {
        $statusOptions = PrisonerStatus::cases();
        $securityLevelOptions = SecurityLevel::cases();
        $sexOptions = Sex::cases();

        return view('livewire.store-prisoner', compact('statusOptions', 'securityLevelOptions', 'sexOptions'));
    }
}
