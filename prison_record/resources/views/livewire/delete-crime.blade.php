<div>
    <button type="button" wire:click="deleteCrime,{{$crime->id}}" wire:loading.attr="disabled" wire:target="deleteCrime"
        class="px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-md shadow-sm hover:from-red-600 hover:to-red-700 transition duration-200 ease-in-out inline-flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
        <span wire:loading.remove wire:target="deleteCrime">Delete</span>
        <span wire:loading wire:target="delete" class="flex items-center">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            Deleting...
        </span>
    </button>
</div>