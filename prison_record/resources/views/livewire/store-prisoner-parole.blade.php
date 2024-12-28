<div">
    <!-- Modal Backdrop -->
    <div x-show="open" style="display: none" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75">
    </div>

    <!-- Modal Content -->
    <div x-show="open" style="display: none" class="fixed inset-0 z-10 overflow-y-auto" @click.away="open = false"
        @keydown.escape.window="open = false" @parole-stored.window="open = false">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative px-8 pt-6 pb-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-2xl sm:p-8">

                <!-- Modal Header -->
                <div class="mb-6">
                    <h3 class="text-xl font-medium leading-6 text-gray-900">Add New Parole Record</h3>
                </div>

                <!-- Modal Form -->
                <form wire:submit.prevent="storeParole">
                    <div class="space-y-6" x-data="{
                        open: false,
                        search: @entangle('search'),
                        selectedPrisoner: @entangle('prisoner'),
                        prisoners: @js($availablePrisoners)
                    }">
                        <!-- Prisoner ID Field -->
                        <div class="relative">
                            <label for="prisoner" class="block mb-2 text-sm font-medium text-gray-700">Prisoner
                                ID</label>
                            <input type="text" id="prisoner" x-model="search" @focus="open = true"
                                @click.away="open = false" wire:model.live="search"
                                class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>

                            @error('search')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div x-show="open" x-transition
                                class="absolute z-50 w-full mt-1 overflow-y-auto bg-white border border-gray-300 rounded-md shadow-lg max-h-60">
                                <ul class="divide-y divide-gray-200">
                                    <template
                                        x-for="prisoner in prisoners.filter(p => p.prisoner_id.toLowerCase().includes(search.toLowerCase()))"
                                        :key="prisoner.id">
                                        <li @click="selectedPrisoner = prisoner.id; search = prisoner.prisoner_id; open = false; $wire.set('prisoner_id', prisoner.id); $wire.set('search', prisoner.prisoner_id)"
                                            class="px-4 py-2 transition duration-200 cursor-pointer hover:bg-blue-50 focus:bg-blue-100">
                                            <div class="flex items-center">
                                                <span x-text="prisoner.prisoner_id + ' =>'"
                                                    class="font-medium text-gray-900"></span>
                                                <span class="ml-2 text-gray-700"
                                                    x-text="prisoner.first_name + ' ' + prisoner.last_name"></span>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <!-- Parole Type Field -->
                        <div>
                            <label for="parole_type" class="block mb-2 text-sm font-medium text-gray-700">Parole
                                Type</label>
                            <select name="parole_type" id="parole_type" wire:model.live="parole_type"
                                class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="">Select a type</option>
                                <option value="regular">Regular Parole</option>
                                <option value="medical">Medical Parole</option>
                            </select>
                            @error('parole_type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sentence Year Reduction Field -->
                        <div>
                            <label for="sentence_reduction"
                                class="block mb-2 text-sm font-medium text-gray-700">Sentence Year Reduction</label>
                            <input type="number" wire:model.live="sentence_reduction" id="sentence_reduction" min="1"
                                step="1"
                                class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('sentence_reduction')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-center gap-4 mt-8">
                        <button type="submit"
                            class="inline-flex justify-center rounded-md bg-blue-600 px-4 py-2.5 text-base font-semibold text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            Add Record
                        </button>
                        <button type="button" @click="open = false"
                            class="inline-flex justify-center rounded-md bg-white px-4 py-2.5 text-base font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>