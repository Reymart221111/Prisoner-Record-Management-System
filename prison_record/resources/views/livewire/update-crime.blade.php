<div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Crime</h2>

    <!-- Success and Error Flash Messages -->
    @if (session()->has('success') || session()->has('error'))
    <div x-data="{ showFlash: true }" x-show="showFlash" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="mb-4 p-4 rounded-lg border shadow-md flex items-start justify-between 
        {{ session()->has('success') ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' }}">

        <div class="flex items-center">
            <svg class="h-6 w-6 {{ session()->has('success') ? 'text-green-500' : 'text-red-500' }} mr-2"
                fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="{{ session()->has('success') ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm-1-7h2v2a1 1 0 11-2 0v-2zm0-4h2v2H9V7z' : 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' }}"
                    clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') ?? session('error') }}</span>
        </div>

        <button @click="showFlash = false"
            class="text-{{ session()->has('success') ? 'green-500 hover:text-green-800' : 'red-500 hover:text-red-800' }} focus:outline-none">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    @endif

    <form wire:submit.prevent="updateCrime" class="space-y-4">
        <div class="space-y-2">
            <label for="crime_name" class="block text-sm font-medium text-gray-700">Crime Name</label>
            <input type="text" id="crime_name" name="crime_name" wire:model.live="crime_name"
                class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                placeholder="Enter crime name" required>
            @error('crime_name')
            <span class="text-red-500 text-sm italic mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <button x-data="{ url: '{{ url()->previous() }}' }" @click="window.location.href = url"
                class="px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600 transition duration-200">
                Cancel
            </button>
            <button type="submit" wire:loading.attr="disabled" wire:target="updateCrime"
                class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-semibold rounded-md shadow hover:from-indigo-600 hover:to-indigo-800 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center"
                {{ $errors->has('crime_name') ? 'disabled' : '' }}>
                <span wire:loading.remove wire:target="updateCrime">
                    Update Crime
                </span>
                <span wire:loading wire:target="updateCrime" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Updating...
                </span>
            </button>
        </div>
    </form>
</div>