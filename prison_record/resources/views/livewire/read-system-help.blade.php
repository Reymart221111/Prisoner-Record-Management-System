@php
$rolePrefix;
$superadmin;

if (Auth::user()->role === 'superadmin') {
$rolePrefix = 'superadmin';
} elseif (Auth::user()->role === 'admin') {
$rolePrefix = 'admin';
} elseif (Auth::user()->role === 'employee') {
$rolePrefix = 'employee';
}

if($rolePrefix === 'superadmin') {
$superadmin = true;
} else {
$superadmin = false;
}
@endphp

<div class="bg-white rounded-lg shadow-md">
    @include('livewire.includes.session-message')
    <!-- Header Section -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <!-- Search Field -->
                <div class="relative">
                    <input type="text" placeholder="Search help articles..." wire:model.live.debounce.200ms="search"
                        class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 placeholder-gray-400 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>
            <!-- Action Buttons -->
            @can('create', App\Models\Help::class)
            <div class="flex items-center space-x-3 ml-4">
                <a href="{{ route('superadmin.help.create') }}"
                    class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="mr-2 fas fa-plus"></i>
                    Create New
                </a>
            </div>
            @endcan
        </div>
    </div>

    <!-- Help Articles List -->
    <div class="p-6">
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Last Updated
                        </th>
                        <th scope="col" @class([ 'px-9'=> $superadmin,
                            'px-4' => !$superadmin,
                            'py-3',
                            'text-right',
                            'text-xs',
                            'font-medium',
                            'text-gray-500',
                            'uppercase',
                            'tracking-wider',
                            ])>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Sample Row -->
                    @foreach ($helps as $systemHelp)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{$systemHelp->title}}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{$systemHelp->updated_at->format('M d, Y h:i A')}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{route($rolePrefix . '.help.show', [$systemHelp->id])}}"
                                class="text-yellow-600 hover:text-yellow-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('update', App\Models\Help::class)
                            <a href="{{route($rolePrefix . '.help.update', [$systemHelp->id])}}"
                                class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan

                            @can('delete', App\Models\Help::class)
                            <button wire:click='deleteArticle({{$systemHelp->id}})'
                                wire:confirm='Are you sure to delete this record?'
                                class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endcan

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            {{ $helps->links() }}
        </div>
    </div>
</div>