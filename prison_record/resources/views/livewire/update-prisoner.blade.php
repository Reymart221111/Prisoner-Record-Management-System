<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="@include('includes.x-data-update')" x-init="initForm">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-xl">
        <div class="px-8 py-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900">Update Prisoner</h2>
            <p class="mt-2 text-sm text-gray-500">Update the prisoner's information in the form below</p>
        </div>

        <!-- Flash Message -->
        @if (session()->has('message'))
        <div x-data="{ showFlash: true }" x-show="showFlash" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300 shadow-md flex items-start justify-between">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-7h2v2a1 1 0 11-2 0v-2zm0-4h2v2H9V7z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('message') }}</span>
            </div>
            <button @click="showFlash = false" class="text-green-500 hover:text-green-800 focus:outline-none">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        @elseif(session()->has('error'))
        <div x-data="{ showFlash: true }" x-show="showFlash" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg border border-red-300 shadow-md flex items-start justify-between">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="showFlash = false" class="text-red-500 hover:text-red-800 focus:outline-none">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        @endif

        <form wire:submit.prevent="updatePrisoner" :class="formClass">
            <!-- Two Column Layout for Main Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Personal Information Column -->
                <div class="space-y-8">
                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>

                    <div>
                        <label for="prisoner_id" class="block text-sm font-medium text-gray-700">Prisoner ID<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="prisoner_id" wire:model.live="prisoner_id"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('prisoner_id') border-red-500 @enderror">
                        @error('prisoner_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name<span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="first_name" wire:model.live="first_name"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
                            @error('first_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name<span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="last_name" wire:model.live="last_name"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('last_name') border-red-500 @enderror">
                            @error('last_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="nationality" wire:model.live="nationality"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nationality') border-red-500 @enderror">
                        @error('nationality')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="height" class="block text-sm font-medium text-gray-700">Height (cm)<span
                                    class="text-red-500">*</span></label>
                            <input type="number" id="height" wire:model.live="height" step="0.1"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('height') border-red-500 @enderror"
                                placeholder="175.5">
                            @error('height')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700">Weight (kg)<span
                                    class="text-red-500">*</span></label>
                            <input type="number" id="weight" wire:model.live="weight" step="0.1"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('weight') border-red-500 @enderror"
                                placeholder="70.5">
                            @error('weight')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of
                            Birth<span class="text-red-500">*</span></label>
                        <input type="date" id="date_of_birth" wire:model.live="date_of_birth"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('date_of_birth') border-red-500 @enderror">
                        @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sex" class="block text-sm font-medium text-gray-700">Sex<span
                                class="text-red-500">*</span></label>
                        <select id="sex" wire:model.live="sex"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sex') border-red-500 @enderror">
                            <option value="">Select sex</option>
                            @foreach ($sexOptions as $sex)
                            <option value="{{ $sex->value }}">{{ $sex->value }}</option>
                            @endforeach
                        </select>
                        @error('sex')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Case Information Column -->
                <div class="space-y-8">
                    <h3 class="text-lg font-semibold text-gray-900">Case Information</h3>

                    <div>
                        <label for="admission_date" class="block text-sm font-medium text-gray-700">Admission
                            Date<span class="text-red-500">*</span></label>
                        <input type="date" id="admission_date" wire:model.live="admission_date"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('admission_date') border-red-500 @enderror">
                        @error('admission_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="release_date" class="block text-sm font-medium text-gray-700">Expected Release
                            Date</label>
                        <input type="date" id="release_date" wire:model.live="release_date"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('release_date') border-red-500 @enderror">
                        @error('release_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="cell_block" class="block text-sm font-medium text-gray-700">Cell Block<span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="cell_block" wire:model.live="cell_block"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('cell_block') border-red-500 @enderror">
                            @error('cell_block')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cell_number" class="block text-sm font-medium text-gray-700">Cell
                                Number<span class="text-red-500">*</span></label>
                            <input type="text" id="cell_number" wire:model.live="cell_number"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('cell_number') border-red-500 @enderror">
                            @error('cell_number')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Information -->
            <div x-data="{ status: @entangle('status'), securityLevel: @entangle('security_level'), showStatusNote: @entangle('status_note') }"
                class="border-t pt-8 space-y-8">
                <h3 class="text-lg font-semibold text-gray-900">Security Information</h3>

                <!-- Status Field with Badge -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status<span
                            class="text-red-500">*</span></label>
                    <div class="mt-2 flex items-center space-x-4">
                        <select id="status" wire:model.live="status" x-model="status"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            @foreach ($statusOptions as $status)
                            <option value="{{ $status->value }}">{{ $status->getLabel() }}</option>
                            @endforeach
                        </select>
                        <!-- Status Badge -->
                        <span x-show="status" x-text="status.charAt(0).toUpperCase() + status.slice(1)"
                            :class="statusBadgeColor" class="px-3 py-1 rounded-full text-sm font-medium"></span>
                    </div>
                    @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Note (Conditional) -->
                <div x-show="['released', 'escaped', 'deceased', 'transferred'].includes(status)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0" class="border-t pt-4">
                    <label for="status_note" class="block text-sm font-medium text-gray-700">Status Note<span
                            class="text-red-500">*</span></label>
                    <textarea id="status_note" wire:model.live="status_note" rows="3"
                        class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status_note') border-red-500 @enderror"
                        placeholder="Please provide additional details about the status change..."></textarea>
                    @error('status_note')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Security Level with Visual Indicators -->
                <div>
                    <label for="security_level" class="block text-sm font-medium text-gray-700">Security Level<span
                            class="text-red-500">*</span></label>
                    <select id="security_level" wire:model.live="security_level" x-model="securityLevel"
                        class="mt-2 w-full rounded-lg shadow-sm focus:ring-blue-500 transition-colors duration-300 @error('security_level') border-red-500 @enderror"
                        :class="{'border-green-300': securityLevel === 'minimum', 'border-yellow-300': securityLevel === 'medium', 'border-orange-300': securityLevel === 'maximum', 'border-red-300': securityLevel === 'supermax'}">
                        <option value="">Select Security Level</option>
                        @foreach ($securityLevelOptions as $level)
                        <option value="{{ $level->value }}">{{ $level->getLabel() }}</option>
                        @endforeach
                    </select>
                    @error('security_level')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Additional Information -->
            <div class="border-t pt-8 space-y-8">
                <h3 class="text-lg font-semibold text-gray-900">Additional Information</h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label for="medical_conditions" class="block text-sm font-medium text-gray-700">Medical
                                Conditions</label>
                            <textarea id="medical_conditions" wire:model.live="medical_conditions" rows="4"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="List any medical conditions..."></textarea>
                            @error('medical_conditions')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="current_medications" class="block text-sm font-medium text-gray-700">Current
                                Medications</label>
                            <textarea id="current_medications" wire:model.live="current_medications" rows="4"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="List current medications..."></textarea>
                            @error('current_medications')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="emergency_contact" class="block text-sm font-medium text-gray-700">Emergency
                                Contact Name</label>
                            <input type="text" id="emergency_contact" wire:model.live="emergency_contact"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('emergency_contact')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="emergency_phone" class="block text-sm font-medium text-gray-700">Emergency
                                Contact Phone</label>
                            <input type="tel" id="emergency_phone" wire:model.live="emergency_phone"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('emergency_phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="relationship" class="block text-sm font-medium text-gray-700">Relationship to
                                Prisoner</label>
                            <input type="text" id="relationship" wire:model.live="relationship"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('relationship')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Upload Section -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prisoner Photo</label>
                            <div class="mt-2">
                                <!-- Preview Area -->
                                <template x-if="photoPreview">
                                    <div class="mb-2">
                                        <img :src="photoPreview" alt="Preview"
                                            class="object-cover rounded-lg h-48 w-full">
                                    </div>
                                </template>

                                <div class="flex justify-center px-6 py-6 border-2 border-gray-300 border-dashed rounded-lg"
                                    :class="{'border-blue-300 bg-blue-50': photoPreview}">
                                    <div class="space-y-2 text-center">
                                        <div class="text-sm text-gray-600">
                                            <label
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span x-text="photoPreview ? 'Change photo' : 'Upload a photo'"></span>
                                                <input type="file" class="sr-only" accept="image/*"
                                                    wire:model.live="photo" @change="const file = $event.target.files[0];
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => {
                                                        photoPreview = e.target.result;
                                                    };
                                                    reader.readAsDataURL(file);">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="border-t pt-8 flex justify-end space-x-4">
                @if(Auth::user()->role === 'superadmin')
                <a href="{{ route('superadmin.prisoners.index') }}"
                    class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 inline-flex items-center transition-colors duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Cancel
                </a>
                @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.prisoners.index') }}"
                    class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 inline-flex items-center transition-colors duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Cancel
                </a>
                @elseif(Auth::user()->role === 'employee')
                <a href="{{ route('employee.prisoners.index') }}"
                    class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 inline-flex items-center transition-colors duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Cancel
                </a>
                @endif
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                    Update Prisoner Record
                </button>
            </div>
        </form>
    </div>
</div>