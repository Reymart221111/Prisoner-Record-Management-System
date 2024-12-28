<div>
    <!-- Modal Backdrop -->
    <div x-show="openInsertModal" style="display: none" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75">
    </div>

    <!-- Modal Content -->
    <div x-show="openInsertModal" style="display: none" class="fixed inset-0 z-10 overflow-y-auto"
        @keydown.escape.window="openInsertModal = false" @record-updated.window="openInsertModal = false;">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative px-8 pt-6 pb-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-2xl sm:p-8">

                <!-- Modal Header -->
                <div class="mb-6">
                    <h3 class="text-xl font-medium leading-6 text-gray-900 text-center">Add New User
                    </h3>
                </div>

                <!-- Modal Form -->
                <form wire:submit.prevent="storeUser">
                    <div class="space-y-6" x-data="{
                        open: false,
                    }">
                        <!-- First Name Field -->
                        <div>
                            <label for="firstName" class="block mb-2 text-sm font-medium text-gray-700">First
                                Name</label>
                            <input type="text" wire:model.live="firstName" id="firstName"
                                class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('firstName')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name Field -->
                        <div>
                            <label for="lastName" class="block mb-2 text-sm font-medium text-gray-700">First
                                Name</label>
                            <input type="text" wire:model.live="lastName" id="lastName"
                                class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('lastName')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model.live="email" id="email"
                                class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="relative" x-data="{ show: false }">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                            <div class="relative">
                                <input type="password" wire:model.live="password" id="password"
                                    class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-12"
                                    required :type="show ? 'text' : 'password'">

                                <button type="button"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600"
                                    @click="show = !show">
                                    <svg class="w-5 h-5 transition-all duration-200" x-show="!show" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="w-5 h-5 transition-all duration-200" x-show="show" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role Selection Field -->
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-700">Role</label>
                            <select wire:model.live="role" id="role"
                                class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="">Select a role</option>
                                @if (Auth::user()->role === 'superadmin')
                                <option value="admin">Admin</option>
                                <option value="employee">Employee</option>
                                @else
                                <option value="employee">Employee</option>
                                @endif
                            </select>
                            @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-center gap-4 mt-8">
                        <button type="submit"
                            class="inline-flex justify-center rounded-md bg-blue-600 px-4 py-2.5 text-base font-semibold text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            Store User Info
                        </button>
                        <button type="button" @click="openInsertModal = false;"
                            class="inline-flex justify-center rounded-md bg-white px-4 py-2.5 text-base font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>