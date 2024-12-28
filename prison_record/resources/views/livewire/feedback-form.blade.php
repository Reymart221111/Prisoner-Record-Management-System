<div class="max-w-2xl mx-auto">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h3 class="mb-6 text-xl font-semibold text-gray-800">Submit Your Feedback</h3>

        <form wire:submit.prevent="submit">
            <!-- Feedback Type -->
            <div class="mb-6">
                <label for="feedback_type" class="block mb-2 text-sm font-medium text-gray-700">
                    Feedback Type
                </label>
                <select id="feedback_type" wire:model="feedback_type"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="suggestion">Suggestion</option>
                    <option value="complaint">Complaint</option>
                    <option value="bug_report">Bug Report</option>
                    <option value="other">Other</option>
                </select>
                @error('feedback_type')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Subject -->
            <div class="mb-6">
                <label for="subject" class="block mb-2 text-sm font-medium text-gray-700">
                    Subject
                </label>
                <input type="text" id="subject" wire:model="subject"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Brief description of your feedback">
                @error('subject')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Feedback Message -->
            <div class="mb-6">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-700">
                    Your Feedback
                </label>
                <textarea id="message" wire:model="message" rows="6"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Please provide detailed feedback..."></textarea>
                @error('message')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Priority Level -->
            <div class="mb-6">
                <label for="priority" class="block mb-2 text-sm font-medium text-gray-700">
                    Priority Level
                </label>
                <select id="priority" wire:model="priority"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>
                @error('priority')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Multiple Image Upload -->
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-700">
                    Attach Images (Optional)
                </label>
                <div class="relative" x-data="{ isDropping: false }" x-on:dragover.prevent="isDropping = true"
                    x-on:dragleave.prevent="isDropping = false" x-on:drop.prevent="isDropping = false"
                    :class="{ 'border-blue-500': isDropping }">

                    <input type="file" id="images" wire:model="images" multiple accept="image/*" class="hidden">
                    <label for="images"
                        class="flex items-center justify-center w-full p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer hover:border-blue-500">
                        <div class="text-center">
                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600">Click to upload images or drag and drop</p>
                            <p class="text-sm text-gray-500">Maximum 5 images (2MB each)</p>
                        </div>
                    </label>
                </div>
                @error('images.*')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror

                <!-- Image Preview -->
                @if(count($temporaryImages) > 0)
                <div class="grid grid-cols-2 gap-4 mt-4">
                    @foreach($temporaryImages as $index => $image)
                    <div class="relative group">
                        <div class="relative aspect-w-3 aspect-h-2">
                            <img src="{{ $image['url'] }}" class="object-cover w-full h-40 rounded-lg">
                            <button type="button" wire:click="removeImage({{ $index }})"
                                class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    wire:loading.attr="disabled" wire:loading.class="opacity-50">
                    <span wire:loading.remove>Submit Feedback</span>
                    <span wire:loading>Submitting...</span>
                </button>
            </div>
        </form>

        <!-- Success Message -->
        @if(session('success'))
        <div class="p-4 mt-6 text-green-700 bg-green-100 rounded-md">
            {{ session('success') }}
        </div>
        @endif
    </div>
</div>