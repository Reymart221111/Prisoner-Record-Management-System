@php
use Carbon\Carbon;
@endphp

<div class="container mx-auto" x-data="{openInsertModal: false, openEditModal: false }">
    @include('livewire.includes.session-message')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">User Roles And Permission</h1>
        <button @click="openInsertModal = true"
            class="flex items-center px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            <i class="mr-2 fas fa-plus"></i>
            Add New User
        </button>
    </div>

    <!-- Search and Filter Section -->
    <div class="p-4 mb-6 bg-white rounded-lg shadow">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <!-- Search Field -->
            <div class="relative">
                <input wire:model.live="search" type="text" placeholder="Search Users..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="absolute text-gray-400 fas fa-search right-3 top-3"></i>
            </div>

            <!-- Sort Field -->
            <div>
                <select wire:model.live="sortField"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sort By</option>
                    <option value="name">Name</option>
                    <option value="id">User ID</option>
                    <option value="created_at">User Created</option>
                    <option value="updated_at">User Updated</option>
                </select>
            </div>
        </div>
    </div>


    @livewire('store-user-role')
    @livewire('update-user-permission')


    <!-- Table Section -->
    <div class="overflow-hidden bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('id')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        User Id
                        @if($sortField === 'id')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('name')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        Name
                        @if($sortField === 'name')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('email')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        Email
                        @if($sortField === 'email')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('role')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        Role
                        @if($sortField === 'role')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('created_at')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        User Created
                        @if($sortField === 'created_at')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('updated_at')"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                        User Updated
                        @if($sortField === 'updated_at')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Sample Row 1 -->
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-8 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{$user->id}}</div>
                    </td>
                    <td class="px-1 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10">
                                <div class="flex-shrink-0 w-10 h-10">
                                    <img class="w-10 h-10 rounded-full"
                                        src="{{ $user->imgPath ? asset('storage/' . $user->imgPath) : asset('storage/uploads/no-photo/no-photo.png') }}"
                                        alt="user photo">
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{$user->getFullName()}}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{$user->email}}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{$user->role}}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{Carbon::parse($user->created_at)->format('M d, Y H:i:s')}}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{Carbon::parse($user->updated_at)->format('M d, Y H:i:s')}}
                        </div>
                    </td>

                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                        @if($user->role === 'superadmin')
                        <span class="text-gray-400">Protected</span>
                        @elseif($user->role === 'admin' && Auth::user()->role === 'admin')
                        <span class="text-gray-400">Protected</span>
                        @else
                        <div class="flex items-center space-x-2">
                            <button @click="openEditModal = true"
                                wire:click='$dispatch("editUser", {recordId: {{ $user->id }} })'
                                class="text-blue-600 hover:text-blue-900 @if (Auth::user()->role === 'admin') mx-5 @endif">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if (Auth::user()->role === 'superadmin')
                            <button wire:click="deleteUser({{$user->id}})"
                                wire:confirm.prompt='Are you sure to delete this record\nType CONFIRM|CONFIRM'
                                class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endif
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            {{$users->links()}}
        </div>
    </div>
</div>