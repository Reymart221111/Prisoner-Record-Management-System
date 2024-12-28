<div class="max-w-md p-6 mx-auto bg-white rounded-lg shadow-lg">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Add New Crime Record</h2>

    <!-- Success and Error Flash Messages -->
    @include('livewire.includes.session-message')

    <form wire:submit.prevent="attachCrime" class="space-y-4">
      <!-- Crime Autocomplete -->
        <div x-data="{ 
            open: false,
            search: @entangle('search'),
            selectedCrime: @entangle('crime'),
            crimes: @js($availableCrimes)
        }" class="space-y-2">
            <label for="crime" class="block text-sm font-medium text-gray-700">Crime</label>
            <div class="relative">
                <input type="text" id="crime" x-model="search" @focus="open = true" @click.away="open = false"
                    wire:model.live="search"
                    class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 @error('search') border-red-500 @enderror"
                    placeholder="Select or type crime name">

                <div x-show="open" x-transition
                    class="absolute z-50 w-full mt-1 overflow-y-auto bg-white border border-gray-200 rounded-md shadow-lg max-h-60">
                    <ul>
                        <template
                            x-for="crime in crimes.filter(c => c.crime_name.toLowerCase().includes(search.toLowerCase()))"
                            :key="crime.id">
                            <li @click="selectedCrime = crime.id; search = crime.crime_name; open = false; $wire.set('crime', crime.id); $wire.set('search', crime.crime_name)"
                                class="px-4 py-2 transition duration-200 cursor-pointer hover:bg-indigo-50"
                                x-text="crime.crime_name">
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
            @error('search')
            <span class="mt-1 text-sm italic text-red-500">{{ $message }}</span>
            @enderror
            @error('crime')
            <span class="mt-1 text-sm italic text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Date Committed -->
        <div class="space-y-2">
            <label for="committed_date" class="block text-sm font-medium text-gray-700">Date Committed</label>
            <input type="date" id="committed_date" wire:model.live="committed_date"
                class="w-full px-4 py-2 transition duration-200 bg-gray-100 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required>
            @error('committed_date')
            <span class="mt-1 text-sm italic text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Additional Notes -->
        <div class="space-y-2">
            <label for="additional_notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
            <textarea id="additional_notes" wire:model.live="additional_notes" rows="4"
                class="w-full px-4 py-2 transition duration-200 bg-gray-100 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="Enter additional details about the crime"></textarea>
            @error('additional_notes')
            <span class="mt-1 text-sm italic text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-4">
            <button x-data @click="window.history.go(-1)"
                class="px-4 py-2 text-white transition duration-200 bg-gray-500 rounded-md shadow hover:bg-gray-600">
                Cancel
            </button>
            <button type="submit"
                class="px-4 py-2 font-semibold text-white transition duration-200 rounded-md shadow bg-gradient-to-r from-indigo-500 to-indigo-700 hover:from-indigo-600 hover:to-indigo-800">
                Add Crime Record
            </button>
        </div>
    </form>
</div>