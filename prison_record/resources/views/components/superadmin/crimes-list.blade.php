<div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Crimes</h2>
        <div class="flex space-x-4 items-center">
            @if(Auth::user()->role === 'superadmin')
            <form action="{{ route('superadmin.crimes.search') }}" method="get" class="relative">
                <div class="flex items-center space-x-4">
                    <div class="relative w-64">
                        <input type="text" name="crime_name" value="{{ request('crime_name') }}"
                            class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                            placeholder="Search crimes..." />
                        <button type="submit"
                            class="absolute right-0 top-1/2 transform -translate-y-1/2 px-3 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600 transition duration-200">
                            Search
                        </button>
                    </div>
                </div>
            </form>
            <a href="{{ route('superadmin.crimes.create') }}"
                class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-semibold rounded-lg px-4 py-2 shadow-md hover:from-indigo-600 hover:to-indigo-800 transition duration-200">
                Add Crime
            </a>
            @elseif(Auth::user()->role === 'admin')
            <form action="{{ route('admin.crimes.search') }}" method="get" class="relative">
                <div class="flex items-center space-x-4">
                    <div class="relative w-64">
                        <input type="text" name="crime_name" value="{{ request('crime_name') }}"
                            class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                            placeholder="Search crimes..." />
                        <button type="submit"
                            class="absolute right-0 top-1/2 transform -translate-y-1/2 px-3 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600 transition duration-200">
                            Search
                        </button>
                    </div>
                </div>
            </form>
            <a href="{{ route('admin.crimes.create') }}"
                class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-semibold rounded-lg px-4 py-2 shadow-md hover:from-indigo-600 hover:to-indigo-800 transition duration-200">
                Add Crime
            </a>
            @elseif(Auth::user()->role === 'employee')
            <form action="{{ route('employee.crimes.search') }}" method="get" class="relative">
                <div class="flex items-center space-x-4">
                    <div class="relative w-64">
                        <input type="text" name="crime_name" value="{{ request('crime_name') }}"
                            class="w-full rounded-lg px-4 py-2 bg-gray-100 focus:bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                            placeholder="Search crimes..." />
                        <button type="submit"
                            class="absolute right-0 top-1/2 transform -translate-y-1/2 px-3 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600 transition duration-200">
                            Search
                        </button>
                    </div>
                </div>
            </form>
            <a href="{{ route('employee.crimes.create') }}"
                class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-semibold rounded-lg px-4 py-2 shadow-md hover:from-indigo-600 hover:to-indigo-800 transition duration-200">
                Add Crime
            </a>
            @endif
        </div>
    </div>
    @include('includes.session-message')
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 font-semibold text-sm uppercase tracking-wide">
                    <th class="px-6 py-4 text-left">ID</th>
                    <th class="px-6 py-4 text-left">Crime Name</th>
                    <th class="px-12 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Sample Data -->
                @foreach ($crimes as $crime)
                <tr class="hover:bg-gray-100 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm text-gray-800">{{$crime->id}}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{$crime->crime_name}}</td>
                    <td class="px-10 py-4 flex space-x-2">
                        @if (Auth::user()->role === 'superadmin')
                        <a href="{{ route('superadmin.crimes.update', [$crime->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            Update
                        </a>
                        @elseif (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.crimes.update', [$crime->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            Update
                        </a>
                        @elseif (Auth::user()->role === 'employee')
                        <a href="{{ route('employee.crimes.update', [$crime->id]) }}"
                            class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-md shadow-sm hover:from-green-600 hover:to-green-700 transition duration-200 ease-in-out inline-block">
                            Update
                        </a>
                        @endif

                        @if (Auth::user()->role === 'superadmin')
                        @livewire('delete-crime', [$crime->id, 'page' => request()->query('page', 1)])
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $crimes->links() }}
        </div>
    </div>
</div>