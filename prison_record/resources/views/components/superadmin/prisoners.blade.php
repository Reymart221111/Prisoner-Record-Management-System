<div class="space-y-6" x-data="{ 
        isOpen: false,
         clearForm() {
            document.querySelectorAll('input, select').forEach(field => {
                if (field.type !== 'hidden') {
                    field.value = '';
                }
            });
        }
    }">
    @include('includes.session-message')
    <!-- Action Buttons with Search -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Prisoner Records</h1>
        <div class="flex space-x-3">
            <button @click="isOpen = true"
                class="inline-flex items-center px-4 py-2 text-white transition duration-150 ease-in-out bg-indigo-600 rounded-lg hover:bg-indigo-700">
                <i class="mr-2 fas fa-search"></i>
                <span>Advanced Search</span>
            </button>

            @if(Auth::user()->role === 'superadmin')
            <a href="{{ route('superadmin.prisoners.create') }}"
                class="inline-flex items-center px-4 py-2 text-white transition duration-150 ease-in-out bg-blue-600 rounded-lg hover:bg-blue-700">
                <i class="mr-2 fas fa-plus"></i>
                <span>Add New Prisoner</span>
            </a>
            @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('admin.prisoners.create') }}"
                class="inline-flex items-center px-4 py-2 text-white transition duration-150 ease-in-out bg-blue-600 rounded-lg hover:bg-blue-700">
                <i class="mr-2 fas fa-plus"></i>
                <span>Add New Prisoner</span>
            </a>
            @elseif(Auth::user()->role === 'employee')
            <a href="{{ route('employee.prisoners.create') }}"
                class="inline-flex items-center px-4 py-2 text-white transition duration-150 ease-in-out bg-blue-600 rounded-lg hover:bg-blue-700">
                <i class="mr-2 fas fa-plus"></i>
                <span>Add New Prisoner</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Search Modal -->
    @include('includes.superadmin-search-prisoner-modal')

    <!-- Prisoners Table -->
    @include('components.superadmin.prisoners-table')
</div>