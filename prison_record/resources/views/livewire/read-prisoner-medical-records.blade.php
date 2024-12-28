<div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Prisoners</h2>
        <div class="flex space-x-4 items-center">
            <div class="flex items-center space-x-4">
                <div class="relative w-64">
                    <input type="text" name="crime_name" wire:model.live="search" value=""
                        class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                        placeholder="Search prisoners..." />
                </div>
            </div>
        </div>
    </div>
    @include('includes.session-message')
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 font-semibold text-sm uppercase tracking-wide">
                    <th class="px-6 py-4 text-left">Prisoner ID</th>
                    <th class="px-6 py-4 text-left">Prisoner Name</th>
                    <th class="px-12 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Sample Data -->
                @foreach ($prisoners as $prisoner)
                <tr class="hover:bg-gray-100 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm text-gray-800">{{$prisoner->prisoner_id}}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{$prisoner->getFullNameAttribute()}}</td>
                    <td class="px-6 py-4 flex space-x-2">
                        @if (Auth::user()->role === 'superadmin')
                        <a href="{{ route('superadmin.medical-records.prisoner-medical-records', [$prisoner->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            View Medical Records
                        </a>
                        @elseif (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.medical-records.prisoner-medical-records', [$prisoner->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            View Medical Records
                        </a>
                        @elseif (Auth::user()->role === 'employee')
                        <a href="{{ route('employee.medical-records.prisoner-medical-records', [$prisoner->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            View Medical Records
                        </a>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $prisoners->links() }}
        </div>
    </div>
</div>