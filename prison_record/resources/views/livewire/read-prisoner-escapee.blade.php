@php
use Carbon\Carbon;
@endphp

<div class="container mx-auto" x-data="{openEditModal: false }">
    @include('livewire.includes.session-message')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Prisoner Escapee Management</h1>
    </div>

    <!-- Search and Filter Section -->
    <div class="p-4 mb-6 bg-white rounded-lg shadow">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <!-- Search Field -->
            <div class="relative">
                <input wire:model.live="search" type="text" placeholder="Search prisoners..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="absolute text-gray-400 fas fa-search right-3 top-3"></i>
            </div>

            <!-- Sort Field -->
            <div>
                <select wire:model.live="sortField"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sort By</option>
                    <option value="name">Name</option>
                    <option value="id">Prisoner ID</option>
                    <option value="escape_date">Escape Date</option>
                    <option value="created_at">Record Created</option>
                </select>
            </div>

            <!-- Date Range Fields with Side Labels -->
            <div class="flex items-center gap-0">
                <label for="date_from" class="text-sm font-medium text-gray-700 whitespace-nowrap">Escape Date
                    From:</label>
                <input id="date_from" type="date" wire:model.live="date_from"
                    class="flex-grow px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-center gap-0">
                <label for="date_to" class="text-sm font-medium text-gray-700 whitespace-nowrap">Escape Date To:</label>
                <input id="date_to" type="date" wire:model.live="date_to"
                    class="flex-grow px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>



    @livewire('update-prisoner-escapee')


    <!-- Table Section -->
    <div class="overflow-hidden bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                        Prisoner ID
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                        Name
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Escape Date
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                        Notes
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                        Record Created
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Sample Row 1 -->
                @foreach ($prisonerEscapees as $prisoner)
                <tr class="hover:bg-gray-50">
                    <td class="px-8 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{$prisoner->prisoner->prisoner_id}}</div>
                    </td>
                    <td class="px-1 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10">
                                <div class="flex-shrink-0 w-10 h-10">
                                    <img class="w-10 h-10 rounded-full"
                                        src="{{ $prisoner->prisoner->photo_path ? asset('storage/' . $prisoner->prisoner->photo_path) : asset('storage/uploads/no-photo/no-photo.png') }}"
                                        alt="prisoner photo">
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{$prisoner->prisoner->getFullNameAttribute()}}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{Carbon::parse($prisoner->escape_date)->format('M d, Y')}}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"> {!! nl2br(e($prisoner->notes)) !!}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{$prisoner->created_at}}</div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                        <button
                            @click="openEditModal = true, $wire.dispatch('editEscapee', { recordId: {{$prisoner->id}} })"
                            class="ml-1 text-blue-600 hover:text-green-900"> <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            {{$prisonerEscapees->links()}}
        </div>
    </div>
</div>