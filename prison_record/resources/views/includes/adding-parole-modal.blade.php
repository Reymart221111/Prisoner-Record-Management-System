<!-- Modal Backdrop -->
<div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
</div>

<!-- Modal Content -->
<div x-show="open" class="fixed inset-0 z-10 overflow-y-auto" @click.away="open = false"
    @keydown.escape.window="open = false">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div
            class="relative transform overflow-hidden rounded-lg bg-white px-8 pb-6 pt-6 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-8">

            <!-- Modal Header -->
            <div class="mb-6">
                <h3 class="text-xl font-medium leading-6 text-gray-900">Add New Parole Record</h3>
            </div>

            <!-- Modal Form -->
            <form>
                <div class="space-y-6">
                    <!-- Prisoner ID Field -->
                    <div>
                        <label for="prisoner_id" class="block text-sm font-medium text-black-700 mb-2">Prisoner ID</label>
                        <input type="text" name="prisoner_id" id="prisoner_id"
                            class="w-full py-2 px-3 bg-gray-50 border border-gray-200 rounded-md text-black-500 text-base"
                            required>
                    </div>

                    <!-- Parole Type Field -->
                    <div>
                        <label for="parole_type" class="block text-sm font-medium text-black-700 mb-2">Parole Type</label>
                        <select name="parole_type" id="parole_type"
                            class="w-full py-2 px-3 bg-gray-50 border border-gray-200 rounded-md text-black-500 text-base"
                            required>
                            <option value="">Select a type</option>
                            <option value="regular">Regular</option>
                            <option value="medical">Medical</option>
                        </select>
                    </div>

                    <!-- Sentence Year Reduction Field -->
                    <div>
                        <label for="sentence_reduction" class="block text-sm font-medium text-black-700 mb-2">Sentence Year Reduction</label>
                        <input type="number" name="sentence_reduction" id="sentence_reduction" min="0" step="0.5"
                            class="w-full py-2 px-3 bg-gray-50 border border-gray-200 rounded-md text-black-500 text-base"
                            required>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-8 sm:mt-8 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-4">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md bg-blue-600 px-4 py-2.5 text-base font-semibold text-white shadow-sm hover:bg-blue-500 sm:col-start-2">
                        Add Record
                    </button>
                    <button type="button" @click="open = false"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2.5 text-base font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>