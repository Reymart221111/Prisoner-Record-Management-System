<div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Medical Record</h2>

    <!-- Success and Error Flash Messages -->
    @include('livewire.includes.session-message')

    <form wire:submit.prevent="updateMedicalRecord" class="space-y-4">
        <!-- Medical Diagnosis -->
        <div class="space-y-2">
            <label for="medical_diagnosis" class="block text-sm font-medium text-gray-700">Medical Diagnosis</label>
            <input type="text" id="medical_diagnosis" wire:model.live="medical_diagnosis"
                class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                placeholder="Enter medical diagnosis">
            @error('medical_diagnosis')
            <span class="text-red-500 text-sm italic mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Medication -->
        <div class="space-y-2">
            <label for="medication" class="block text-sm font-medium text-gray-700">Medication</label>
            <textarea id="medication" wire:model.live="medication" rows="4"
                class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                placeholder="Enter medication details"></textarea>
            @error('medication')
            <span class="text-red-500 text-sm italic mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Last Checkup Date -->
        <div class="space-y-2">
            <label for="last_checkup_date" class="block text-sm font-medium text-gray-700">Last Checkup Date</label>
            <input type="date" id="last_checkup_date" wire:model.live="last_checkup_date"
                class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200">
            @error('last_checkup_date')
            <span class="text-red-500 text-sm italic mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Doctor Notes -->
        <div class="space-y-2">
            <label for="doctor_notes" class="block text-sm font-medium text-gray-700">Doctor Notes</label>
            <textarea id="doctor_notes" wire:model.live="doctor_notes" rows="4"
                class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                placeholder="Enter doctor notes"></textarea>
            @error('doctor_notes')
            <span class="text-red-500 text-sm italic mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <button x-data @click="window.history.go(-1)"
                class="px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600 transition duration-200">
                Cancel
            </button>
            
            <button type="submit" wire:loading.attr="disabled" {{ $errors->any()? 'disabled' : '' }}
                class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-700
                text-white font-semibold rounded-md shadow hover:from-indigo-600 hover:to-indigo-800 transition
                duration-200 disabled:opacity-50 disabled:cursor-not-allowed relative">

                <!-- Spinner -->
                <svg wire:loading wire:target="updateMedicalRecord" class="absolute w-5 h-5 text-white animate-spin"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <!-- Button Text -->
                <span wire:loading.remove>Update Medical Record</span>
                <span wire:loading>Updating...</span>
            </button>
        </div>
    </form>
</div>