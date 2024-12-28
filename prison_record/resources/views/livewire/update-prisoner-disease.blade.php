<div>
    <!-- Modal Backdrop -->
    <div x-show="openEditModal" style="display: none" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75">
    </div>

    <!-- Modal Content -->
    <div x-show="openEditModal" style="display: none" class="fixed inset-0 z-10 overflow-y-auto"
        @keydown.escape.window="openEditModal = false; $wire.resetValidation()"
        @record-updated.window="openEditModal = false; $wire.resetValidation()">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative px-8 pt-6 pb-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-2xl sm:p-8">

                <!-- Modal Header -->
                <div class="mb-6">
                    <h3 class="text-xl font-medium leading-6 text-gray-900 text-center">Update Prisoner Escapee Record
                    </h3>
                </div>

                <!-- Modal Form -->
                <form wire:submit.prevent="updateParole">
                    <div class="space-y-6" x-data="{
                        open: false,
                    }">
                        <!-- Escape Date Field -->
                        <div>
                            <label for="death_date" class="block mb-2 text-sm font-medium text-gray-700">Date of Death</label>
                            <input type="date" wire:model.live="death_date" id="death_date"
                                class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('death_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes Field -->
                        <div>
                            <label for="death_cause" class="block mb-2 text-sm font-medium text-gray-700">Cause of Death</label>
                            <textarea wire:model.live="death_cause" id="death_cause" rows="4"
                                class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter any additional death_cause here..."></textarea>
                            @error('death_cause')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-center gap-4 mt-8">
                        <button type="submit"
                            class="inline-flex justify-center rounded-md bg-blue-600 px-4 py-2.5 text-base font-semibold text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            Update Parole Record
                        </button>
                        <button type="button" @click="openEditModal = false; $wire.resetValidation()"
                            class="inline-flex justify-center rounded-md bg-white px-4 py-2.5 text-base font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>