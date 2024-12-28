@if (session()->has('success') || session()->has('error'))
<div x-data="{ showFlash: true }" x-show="showFlash" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform -translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-2"
    class="mb-4 p-4 rounded-lg border shadow-md flex items-start justify-between 
    {{ session()->has('success') ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' }}">

    <div class="flex items-center">
        <svg class="h-6 w-6 {{ session()->has('success') ? 'text-green-500' : 'text-red-500' }} mr-2"
            fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="{{ session()->has('success') ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm-1-7h2v2a1 1 0 11-2 0v-2zm0-4h2v2H9V7z' : 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' }}"
                clip-rule="evenodd" />
        </svg>
        <span>{{ session('success') ?? session('error') }}</span>
    </div>

    <button @click="showFlash = false"
        class="text-{{ session()->has('success') ? 'green-500 hover:text-green-800' : 'red-500 hover:text-red-800' }} focus:outline-none">
        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>
</div>
@endif