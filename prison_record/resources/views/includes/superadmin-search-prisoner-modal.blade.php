<div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto"
    style="background-color: rgba(0,0,0,0.5); display:none" @click="isOpen = false">

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-3xl p-5 mx-auto bg-white rounded-md shadow-lg"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4" @click.stop>

            <div class="flex flex-col">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">Advanced Search</h3>
                    <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                        <i class="text-xl fas fa-times"></i>
                    </button>
                </div>

                <!-- Search Form -->
                <form method="GET" @if(Auth::user()->role === 'superadmin')
                    action="{{ route('superadmin.prisoners.search') }}"
                    @elseif(Auth::user()->role === 'admin')
                    action="{{ route('admin.prisoners.search') }}"
                    @elseif(Auth::user()->role === 'employee')
                    action="{{ route('employee.prisoners.search') }}"
                    @endif>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <!-- Prisoner ID -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prisoner ID</label>
                            <input type="text" id="prisoner_id" name="prisoner_id" value="{{ request('prisoner_id') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" {{ request('status')=='' ? 'selected' : '' }}>All</option>
                                <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="released" {{ request('status')=='released' ? 'selected' : '' }}>Released
                                </option>
                                <option value="transferred" {{ request('status')=='transferred' ? 'selected' : '' }}>
                                    Transferred</option>
                                <option value="deceased" {{ request('status')=='deceased' ? 'selected' : '' }}>Deceased
                                </option>
                            </select>
                        </div>

                        <!-- First Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" value="{{ request('first_name') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" value="{{ request('last_name') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Nationality -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nationality</label>
                            <input type="text" name="nationality" value="{{ request('nationality') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Security Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Security Level</label>
                            <select name="security_level"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" {{ request('security_level')=='' ? 'selected' : '' }}>All</option>
                                <option value="minimum" {{ request('security_level')=='minimum' ? 'selected' : '' }}>
                                    Minimum</option>
                                <option value="medium" {{ request('security_level')=='medium' ? 'selected' : '' }}>
                                    Medium</option>
                                <option value="maximum" {{ request('security_level')=='maximum' ? 'selected' : '' }}>
                                    Maximum</option>
                                <option value="supermax" {{ request('security_level')=='supermax' ? 'selected' : '' }}>
                                    Supermax</option>
                            </select>
                        </div>

                        <!-- Cell Block -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cell Block</label>
                            <input type="text" name="cell_block" value="{{ request('cell_block') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Cell Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cell Number</label>
                            <input type="text" name="cell_number" value="{{ request('cell_number') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Date of Birth Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Birth Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-gray-500">From</label>
                                    <input type="date" name="date_of_birth_from"
                                        value="{{ request('date_of_birth_from') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500">To</label>
                                    <input type="date" name="date_of_birth_to" value="{{ request('date_of_birth_to') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Admission Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Admission Date Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-gray-500">From</label>
                                    <input type="date" name="admission_date_from"
                                        value="{{ request('admission_date_from') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500">To</label>
                                    <input type="date" name="admission_date_to"
                                        value="{{ request('admission_date_to') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Release Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Release Date Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-gray-500">From</label>
                                    <input type="date" name="release_date_from"
                                        value="{{ request('release_date_from') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500">To</label>
                                    <input type="date" name="release_date_to" value="{{ request('release_date_to') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Medical Conditions -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Medical Conditions</label>
                            <input type="text" name="medical_conditions" value="{{ request('medical_conditions') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" @click="isOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="button" @click="clearForm()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">
                            Reset
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Search
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>