<div>
    <a @if (Auth::user()->role === 'superadmin') href="{{ route('superadmin.prisoners.show', ['prisoner' => $prisoner,
        'page' => request()->query('page', 1)])
        }}" @elseif (Auth::user()->role === 'admin') href="{{ route('admin.prisoners.show', ['prisoner' =>
        $prisoner,
        'page' => request()->query('page', 1)])
        }}" @elseif (Auth::user()->role === 'employee') href="{{ route('employee.prisoners.show', ['prisoner' =>
        $prisoner,
        'page' => request()->query('page', 1)])
        }}" @endif
        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-150 ease-in-out
        inline-block">
        View
    </a>
    <a @if (Auth::user()->role === 'superadmin') href="{{ route('superadmin.prisoners.update', $prisoner->id) }}"
        @elseif (Auth::user()->role === 'admin') href="{{ route('admin.prisoners.update', $prisoner->id) }}"
        @elseif (Auth::user()->role === 'employee') href="{{ route('employee.prisoners.update', $prisoner->id) }}"
        @endif
        class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-150 ease-in-out
        inline-block">
        Update
    </a>
    @if (Auth::user()->role === 'superadmin')
    <button wire:click="deletePrisoner({{ $prisoner->id }})" wire:confirm="Are you sure you want to delete this record?"
        class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-150 ease-in-out inline-block">
        Delete
    </button>
    @endif
</div>