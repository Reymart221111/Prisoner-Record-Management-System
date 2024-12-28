<div class="p-8 space-y-8 bg-white rounded-lg shadow-md">
    @include('includes.session-message')
    <!-- Header -->
    <div class="flex items-center justify-between pb-4 mb-6 border-b">
        <div class="flex items-center gap-6">
            <h1 class="text-3xl font-extrabold text-gray-800">Prisoner ID: {{ $prisoner->prisoner_id }}</h1>
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                @if($prisoner->status->value === 'active') bg-green-100 text-green-700
                @elseif($prisoner->status->value === 'escaped') bg-red-100 text-red-700
                @else bg-yellow-100 text-yellow-700
                @endif">
                {{ $prisoner->status_label }}
            </span>
        </div>

        <div class="flex gap-4">
            @if(Auth::user()->role === 'superadmin')
            <a href="{{ route('superadmin.prisoners.update', $prisoner->id) }}"
                class="flex items-center px-5 py-2 text-white transition bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Record
            </a>
            <a href="{{ route('superadmin.prisoners.index', ['page' => $page]) }}"
                class="flex items-center px-5 py-2 text-white transition bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
            @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('admin.prisoners.update', $prisoner->id) }}"
                class="flex items-center px-5 py-2 text-white transition bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Record
            </a>
            <a href="{{ route('admin.prisoners.index', ['page' => $page]) }}"
                class="flex items-center px-5 py-2 text-white transition bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
            @elseif(Auth::user()->role === 'employee')
            <a href="{{ route('employee.prisoners.update', $prisoner->id) }}"
                class="flex items-center px-5 py-2 text-white transition bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Record
            </a>
            <a href="{{ route('employee.prisoners.index', ['page' => $page]) }}"
                class="flex items-center px-5 py-2 text-white transition bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
            @endif
        </div>
    </div>

    <!-- Status Note (conditionally displayed if populated) -->
    @if(!empty($prisoner->status_note))
    <div class="p-4 mt-4 rounded-lg shadow-sm bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-700">Reason for status change:</h3>
        <p class="mt-2 text-gray-600">{{ $prisoner->status_note }}</p>
    </div>
    @endif

    <!-- Main Content -->
    <div class="grid grid-cols-3 gap-8">
        <!-- Left Column - Photo & Basic Info -->
        <div class="space-y-6">
            <div class="overflow-hidden bg-gray-100 rounded-lg shadow-md aspect-w-4 aspect-h-5">
                @if($prisoner->photo_path)
                <img src="{{ asset('storage/' . $prisoner->photo_path) }}" alt="{{ $prisoner->full_name }}"
                    class="object-cover w-full h-full">
                @else
                <img src="{{ asset('storage/uploads/no-photo/no-photo.png') }}" alt="{{ $prisoner->full_name }}"
                    class="object-cover w-full h-full">
                @endif
            </div>

            <div class="space-y-1 text-center">
                <h2 class="text-2xl font-bold text-gray-800">{{ $prisoner->full_name }}</h2>
                <p class="text-gray-500">{{ $prisoner->nationality }}</p>
            </div>

            <div class="p-5 rounded-lg shadow-sm bg-gray-50">
                <div class="flex justify-between font-medium text-gray-600">
                    <span>ID Number:</span>
                    <span>{{ $prisoner->prisoner_id }}</span>
                </div>
                <div class="flex justify-between mt-3 font-medium text-gray-600">
                    <span>Security Level:</span>
                    <span>{{ $prisoner->security_level_label }}</span>
                </div>
            </div>
        </div>

        <!-- Middle Column -->
        <div class="space-y-6">
            <div class="p-5 rounded-lg shadow-md bg-gray-50">
                <h3 class="mb-4 text-lg font-semibold text-gray-700">Personal Information</h3>
                <div class="grid grid-cols-2 font-medium text-gray-600 gap-y-4">
                    <div>
                        <p>Date of Birth</p>
                        <p class="text-gray-900">{{ $prisoner->date_of_birth->format('M d, Y') }}</p>
                        <p class="text-sm text-gray-500">({{ $prisoner->age }} years)</p>
                    </div>
                    <div>
                        <p>Sex</p>
                        <p class="text-gray-900">{{ $prisoner->sex }}</p>
                    </div>
                    <div>
                        <p>Height</p>
                        <p class="text-gray-900">{{ $prisoner->height }} cm</p>
                    </div>
                    <div>
                        <p>Weight</p>
                        <p class="text-gray-900">{{ $prisoner->weight }} kg</p>
                    </div>
                </div>
            </div>

            <div class="p-5 rounded-lg shadow-md bg-gray-50">
                <h3 class="mb-4 text-lg font-semibold text-gray-700">Medical Information</h3>
                <div class="space-y-4 font-medium text-gray-600">
                    <div>
                        <p>Medical Conditions</p>
                        <p class="text-gray-900 whitespace-pre-line">{{ $prisoner->medical_conditions ?: 'None' }}</p>
                    </div>
                    <div>
                        <p>Current Medications</p>
                        <p class="text-gray-900 whitespace-pre-line">{{ $prisoner->current_medications ?: 'None' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <div class="p-5 rounded-lg shadow-md bg-gray-50">
                <h3 class="mb-4 text-lg font-semibold text-gray-700">Detention Information</h3>
                <div class="space-y-4 font-medium text-gray-600">
                    <div>
                        <p>Cell Location</p>
                        <p class="text-gray-900">Block {{ $prisoner->cell_block }}, Cell {{ $prisoner->cell_number }}
                        </p>
                    </div>
                    <div>
                        <p>Admission Date</p>
                        <p class="text-gray-900">{{ $prisoner->admission_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p>Release Date</p>
                        <p class="text-gray-900">{{ $prisoner->release_date ? $prisoner->release_date->format('M d, Y')
                            : 'Indefinite' }}</p>
                    </div>
                </div>
            </div>

            <div class="p-5 rounded-lg shadow-md bg-gray-50">
                <h3 class="mb-4 text-lg font-semibold text-gray-700">Emergency Contact</h3>
                <div class="space-y-4 font-medium text-gray-600">
                    <div>
                        <p>Contact Name</p>
                        <p class="text-gray-900">{{ $prisoner->emergency_contact ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <p>Relationship</p>
                        <p class="text-gray-900">{{ $prisoner->relationship ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <p>Contact Phone</p>
                        <p class="text-gray-900">{{ $prisoner->emergency_phone ?: 'Not provided' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>