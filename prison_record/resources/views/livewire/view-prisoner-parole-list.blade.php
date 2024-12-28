<div class="container mx-auto" x-data="{ open: false, openEditModal: false }">
    @include('livewire.includes.session-message')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Prisoner Parole Management</h1>
        <button @click="open = true"
            class="flex items-center px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            <i class="mr-2 fas fa-plus"></i>
            Add New Parole Record
        </button>
    </div>

    <!-- Search and Filter Section -->
    <div class="p-4 mb-6 bg-white rounded-lg shadow">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="relative">
                <input wire:model.live="search" type="text" placeholder="Search prisoners..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="absolute text-gray-400 fas fa-search right-3 top-3"></i>
            </div>
            <div>
                <select wire:model.live="paroleType"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Filter by Parole Type</option>
                    <option value="regular">Regular Parole</option>
                    <option value="medical">Medical Parole</option>
                </select>
            </div>
            <div>
                <select wire:model.live="sortField"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sort By</option>
                    <option value="name">Name</option>
                    <option value="id">Prisoner ID</option>
                    <option value="sentence_reduction">Sentence Year Reduction</option>
                    <option value="created_at">Record Created</option>
                </select>
            </div>
        </div>
    </div>

    @livewire('store-prisoner-parole')
    @livewire('update-prisoner-parole')


    <!-- Table Section -->
    <div class="overflow-hidden bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('id')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        Prisoner ID
                        @if($sortField === 'id')
                        <i class="ml-1 fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('name')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        Name
                        @if($sortField === 'name')
                        <i class="ml-1 fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Parole Type
                    </th>
                    <th wire:click="sortBy('sentence_reduction')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        Sentence Year Reduction
                        @if($sortField === 'sentence_reduction')
                        <i class="ml-1 fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('created_at')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        Record Created
                        @if($sortField === 'created_at')
                        <i class="ml-1 fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Sample Row 1 -->
                @foreach ($prisonerParoles as $parole)
                <tr class="hover:bg-gray-50">
                    <td class="px-8 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $parole->prisoner->prisoner_id }}</div>
                    </td>
                    <td class="px-1 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10">
                                <img class="w-10 h-10 rounded-full"
                                    src="{{ $parole->prisoner->photo_path ? asset('storage/' . $parole->prisoner->photo_path) : asset('storage/uploads/no-photo/no-photo.png') }}"
                                    alt="prisoner photo">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{
                                    $parole->prisoner->getFullNameAttribute() }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"> {{$parole->parole_type->getLabel()}}</div>
                    </td>
                    <td class="px-16 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{$parole->sentence_reduction}} Years</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{$parole->created_at}}</div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                        <button @click="openEditModal = true"
                            wire:click='$dispatch("editParole", { "paroleId": {{$parole->id}} })'
                            class="mr-3 text-blue-600 hover:text-blue-900">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button wire:click="deleteParole({{$parole->id}})"
                            wire:confirm='Are you sure you want to delete this record?'
                            class="ml-1 text-red-600 hover:text-green-900">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            {{$prisonerParoles->links()}}
        </div>
    </div>
</div>