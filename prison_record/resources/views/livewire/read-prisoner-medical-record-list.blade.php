<div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
    <div class="flex items-start justify-between mb-8">
        <!-- Prisoner Info Section -->
        <div class="flex items-center space-x-6">
            <div class="flex-shrink-0">
                <img src="{{ $prisoner->photo_path ? asset('storage/' . $prisoner->photo_path) : asset('storage/uploads/no-photo/no-photo.png') }}"
                    alt="Prisoner Image" class="h-24 w-24 rounded-full object-cover border-4 border-gray-200 shadow-lg">
            </div>
            <div class="flex flex-col">
                <h2 class="text-3xl font-bold text-gray-800">{{$prisoner->getFullNameAttribute()}}</h2>
                <span class="text-gray-600 text-lg">Prisoner ID: {{$prisoner->prisoner_id}}</span>
            </div>
        </div>

        <!-- Search and Add Section -->
        <div class="flex space-x-4 items-center">
            <div class="flex items-center space-x-4">
                <div class="relative w-64">
                    <input type="text" wire:model.live="search"
                        class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                        placeholder="Search Medical Diagnosis..." />
                </div>
                <div class="relative w-48">
                    <input type="date" wire:model.live="searchDate"
                        class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200" />
                </div>
            </div>
            @if(Auth::user()->role === 'superadmin')
            <a href="{{ route('superadmin.medical-records.create', [$prisoner->id]) }}"
                class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-md shadow-sm hover:from-blue-600 hover:to-blue-700 transition duration-200 ease-in-out inline-block">
                Add Medical Record
            </a>
            @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('admin.medical-records.create', [$prisoner->id]) }}"
                class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-md shadow-sm hover:from-blue-600 hover:to-blue-700 transition duration-200 ease-in-out inline-block">
                Add Medical Record
            </a>
            @elseif(Auth::user()->role === 'employee')
            <a href="{{ route('employee.medical-records.create', [$prisoner->id]) }}"
                class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-md shadow-sm hover:from-blue-600 hover:to-blue-700 transition duration-200 ease-in-out inline-block">
                Add Medical Record
            </a>
            @endif
        </div>
    </div>

    <div class="border-b border-gray-200 mb-6"></div>

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Criminal Record</h3>
    </div>

    @include('includes.session-message')
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 font-semibold text-sm uppercase tracking-wide">
                    <th class="px-6 py-4 text-left">Medical Diagnosis</th>
                    <th class="px-6 py-4 text-left">Last CheckUp Date</th>
                    <th class="px-12 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($medicalRecords as $record)
                <tr class="hover:bg-gray-100 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm text-gray-800">{{$record->medical_diagnosis}}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{$record->last_checkup_date}}</td>
                    <td class="px-6 py-4 flex space-x-2">
                        @if(Auth::user()->role === 'superadmin')
                        <a href="{{ route('superadmin.medical-records.show', [$record->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            View
                        </a>
                        <a href="{{ route('superadmin.medical-records.update', [$record->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            Update
                        </a>
                        @elseif(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.medical-records.show', [$record->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            View
                        </a>
                        <a href="{{ route('admin.medical-records.update', [$record->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            Update
                        </a>
                        @elseif(Auth::user()->role === 'employee')
                        <a href="{{ route('employee.medical-records.show', [$record->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            View
                        </a>
                        <a href="{{ route('employee.medical-records.update', [$record->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            Update
                        </a>
                        @endif

                        @if(Auth::user()->role === 'superadmin')
                        <button wire:click="destroyMedicalRecord({{$record->id}})"
                            wire:confirm="Are you sure you want to delete this record?"
                            class="px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-md shadow-sm hover:from-red-600 hover:to-red-700 transition duration-200 ease-in-out inline-block">
                            Remove
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 flex justify-center">
            <button x-data="{ url: '{{ url()->previous() }}' }" @click="window.location.href = url"
                class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-md shadow-sm hover:from-red-600 hover:to-red-700 transition duration-200 ease-in-out inline-block">
                Exit
            </button>
        </div>

    </div>