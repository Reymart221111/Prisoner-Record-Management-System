<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
        <!-- Article Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">{{ $help->title }}</h3>
                <button x-data="{url: '{{url()->previous()}}'}" @click="window.location.href=url"
                    class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    <i class="mr-2 fas fa-arrow-left"></i>
                    Back to List
                </button>
            </div>
        </div>

        <!-- Article Content -->
        <div class="p-6">
            <div class="trix-content">
                {!! $help->content !!}
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<style>
    /* Basic content styles */
    .trix-content {
        min-height: 20rem;
        padding: 1rem;
        overflow-y: auto;
    }

    /* Lists styling */
    .trix-content ol {
        list-style-type: decimal !important;
        margin: 0.5em 0 !important;
        padding-left: 2em !important;
    }

    .trix-content ul {
        list-style-type: disc !important;
        margin: 0.5em 0 !important;
        padding-left: 2em !important;
    }

    .trix-content ol li,
    .trix-content ul li {
        display: list-item !important;
        margin: 0.3em 0 !important;
    }

    /* Nested lists */
    .trix-content ul ul,
    .trix-content ol ol,
    .trix-content ul ol,
    .trix-content ol ul {
        margin: 0.5em 0 !important;
    }

    /* Headings */
    .trix-content h1 {
        font-size: 1.5em !important;
        margin: 1em 0 0.5em !important;
        font-weight: bold !important;
    }

    /* Links */
    .trix-content a {
        color: #2563eb !important;
        text-decoration: underline !important;
    }

    /* Blockquotes */
    .trix-content blockquote {
        border-left: 4px solid #e5e7eb !important;
        margin: 1.5em 0 !important;
        padding: 1em 1.2em !important;
        background-color: #f9fafb !important;
        border-radius: 0 0.375rem 0.375rem 0 !important;
        color: #4b5563 !important;
        font-style: italic !important;
        position: relative !important;
    }

    .trix-content blockquote::before {
        content: '"' !important;
        font-size: 2em !important;
        color: #9ca3af !important;
        position: absolute !important;
        left: 0.3em !important;
        top: -0.2em !important;
    }

    .trix-content blockquote::after {
        content: '"' !important;
        font-size: 2em !important;
        color: #9ca3af !important;
        position: absolute !important;
        right: 0.3em !important;
        bottom: -0.6em !important;
    }

    .trix-content blockquote p {
        margin: 0 !important;
        line-height: 1.6 !important;
        padding-right: 1em !important;
    }

    /* Code blocks */
    .trix-content pre {
        background: #f3f4f6 !important;
        padding: 1em !important;
        border-radius: 0.375rem !important;
        overflow-x: auto !important;
    }

    /* Inline code */
    .trix-content code {
        background: #f3f4f6 !important;
        padding: 0.2em 0.4em !important;
        border-radius: 0.25rem !important;
        font-family: monospace !important;
    }

    /* Table styles */
    .trix-content table {
        border-collapse: collapse !important;
        width: 100% !important;
        margin: 1em 0 !important;
    }

    .trix-content th,
    .trix-content td {
        border: 1px solid #e5e7eb !important;
        padding: 0.5em !important;
    }

    .trix-content th {
        background-color: #f9fafb !important;
        font-weight: bold !important;
    }

    /* Nested blockquotes */
    .trix-content blockquote blockquote {
        margin-left: 1em !important;
        border-left-color: #d1d5db !important;
        background-color: #ffffff !important;
    }

    /* Lists within blockquotes */
    .trix-content blockquote ul,
    .trix-content blockquote ol {
        margin-top: 0.5em !important;
        margin-bottom: 0.5em !important;
    }
</style>
@endpush