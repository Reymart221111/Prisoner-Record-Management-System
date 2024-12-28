<div class="max-w-4xl mx-auto">
    <!-- Flash Messages -->
    @include('livewire.includes.session-message')

    <div class="bg-white rounded-lg shadow-md">
        <!-- Form Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Create New Help Article</h3>
                <a href="{{ route('superadmin.help.index') }}"
                    class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    <i class="mr-2 fas fa-arrow-left"></i>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-6">
            <form wire:submit.prevent="saveSystemHelpArticle">
                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="title" name="title" wire:model.defer="title"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter help article title">
                    @error('title')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Content with Alpine + Trix -->
                <div wire:ignore>
                    <input id="content" type="hidden" wire:model="content">
                    <trix-editor data-trix-editor x-on:trix-change="$wire.set('content', $event.target.value)"
                        input="content"
                        class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        style="min-height: 20rem;">
                    </trix-editor>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 border-t pt-6">
                    <button x-data="{ url: '{{ url()->previous() }}' }" @click="window.location.href = url"
                        class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Save Help Article
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<style>
    /* Basic editor styles */
    trix-editor {
        min-height: 20rem;
        padding: 1rem;
        overflow-y: auto;
    }

    /* Lists styling */
    trix-editor ol {
        list-style-type: decimal !important;
        margin: 0.5em 0 !important;
        padding-left: 2em !important;
    }

    trix-editor ul {
        list-style-type: disc !important;
        margin: 0.5em 0 !important;
        padding-left: 2em !important;
    }

    trix-editor ol li,
    trix-editor ul li {
        display: list-item !important;
        margin: 0.3em 0 !important;
    }

    /* Nested lists */
    trix-editor ul ul,
    trix-editor ol ol,
    trix-editor ul ol,
    trix-editor ol ul {
        margin: 0.5em 0 !important;
    }

    /* Headings */
    trix-editor h1 {
        font-size: 1.5em !important;
        margin: 1em 0 0.5em !important;
        font-weight: bold !important;
    }

    /* Links */
    trix-editor a {
        color: #2563eb !important;
        text-decoration: underline !important;
    }

    /* Enhanced Blockquotes with opening and closing quotes */
    trix-editor blockquote {
        border-left: 4px solid #e5e7eb !important;
        margin: 1.5em 0 !important;
        padding: 1em 1.2em !important;
        background-color: #f9fafb !important;
        border-radius: 0 0.375rem 0.375rem 0 !important;
        color: #4b5563 !important;
        font-style: italic !important;
        position: relative !important;
    }

    trix-editor blockquote::before {
        content: '"' !important;
        font-size: 2em !important;
        color: #9ca3af !important;
        position: absolute !important;
        left: 0.3em !important;
        top: -0.2em !important;
    }

    trix-editor blockquote::after {
        content: '"' !important;
        font-size: 2em !important;
        color: #9ca3af !important;
        position: absolute !important;
        right: 0.3em !important;
        bottom: -0.6em !important;
    }

    trix-editor blockquote p {
        margin: 0 !important;
        line-height: 1.6 !important;
        padding-right: 1em !important;
        /* Add padding to prevent text overlap with closing quote */
    }

    /* Code blocks */
    trix-editor pre {
        background: #f3f4f6 !important;
        padding: 1em !important;
        border-radius: 0.375rem !important;
        overflow-x: auto !important;
    }

    /* Inline code */
    trix-editor code {
        background: #f3f4f6 !important;
        padding: 0.2em 0.4em !important;
        border-radius: 0.25rem !important;
        font-family: monospace !important;
    }

    /* Table styles */
    trix-editor table {
        border-collapse: collapse !important;
        width: 100% !important;
        margin: 1em 0 !important;
    }

    trix-editor th,
    trix-editor td {
        border: 1px solid #e5e7eb !important;
        padding: 0.5em !important;
    }

    trix-editor th {
        background-color: #f9fafb !important;
        font-weight: bold !important;
    }

    /* Attachment progress */
    trix-editor .attachment__progress {
        height: 0.25rem !important;
        background-color: #e5e7eb !important;
        border-radius: 9999px !important;
    }

    trix-editor .attachment__progress--value {
        background-color: #2563eb !important;
    }

    /* Focus state */
    trix-editor:focus {
        outline: none !important;
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
    }

    /* Nested blockquotes */
    trix-editor blockquote blockquote {
        margin-left: 1em !important;
        border-left-color: #d1d5db !important;
        background-color: #ffffff !important;
    }

    /* Lists within blockquotes */
    trix-editor blockquote ul,
    trix-editor blockquote ol {
        margin-top: 0.5em !important;
        margin-bottom: 0.5em !important;
    }

    /* Add this to your existing styles to hide attachment button */
    .trix-button-group--file-tools {
        display: none !important;
    }

    /* Hide the attachment button specifically */
    .trix-button--icon-attach {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
<script>
    // Disable file attachments in Trix
    addEventListener("trix-file-accept", function(event) {
        event.preventDefault();
    });

    document.addEventListener('livewire:initialized', () => {
        // Remove file tools from toolbar
        addEventListener("trix-initialize", function(event) {
            const toolbar = event.target.toolbarElement;
            const fileTools = toolbar.querySelector(".trix-button-group--file-tools");
            if (fileTools) {
                fileTools.remove();
            }
        });

        Livewire.on('trix-reset', () => {
            let editor = document.querySelector('trix-editor');
            editor.editor.loadHTML('');
        });
    });
</script>
@endpush