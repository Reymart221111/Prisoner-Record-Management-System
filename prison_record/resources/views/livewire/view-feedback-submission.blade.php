<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Submitted Feedback</h1>

    <div class="bg-white shadow-md rounded-lg p-4">
        <!-- Search and Filter Section -->
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
            <!-- Search Bar -->
            <div class="relative w-full md:w-1/3">
                <input type="text" wire:model.live="search" placeholder="Search feedback..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <span class="absolute inset-y-0 right-4 flex items-center">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
            </div>

            <!-- Advanced Filters -->
            <div class="mt-4 md:mt-0 flex space-x-4">
                <select wire:model.live="filter.feedback_type"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="suggestion">Suggestion</option>
                    <option value="complaint">Complaint</option>
                    <option value="bug_report">Bug Report</option>
                    <option value="other">Other</option>
                </select>

                <select wire:model.live="filter.priority"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Priorities</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>

                <select wire:model.live="filter.sort"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="latest">Latest</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>
        </div>

        <!-- Feedback Table -->
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Feedback Id</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Type</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Subject</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Priority</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Date</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                    <tr class="border-t">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $feedback->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($feedback->feedback_type) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $feedback->subject }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            <span class="px-2 py-1 text-xs font-medium text-white rounded-full
                                    @if($feedback->priority === 'low') bg-green-500
                                    @elseif($feedback->priority === 'medium') bg-yellow-500
                                    @elseif($feedback->priority === 'high') bg-orange-500
                                    @elseif($feedback->priority === 'urgent') bg-red-500
                                    @endif">
                                {{ ucfirst($feedback->priority) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $feedback->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-center flex justify-center space-x-2">
                            <!-- View Button -->
                            <a href="{{ route('superadmin.feedbacks.view', ['feedback' => $feedback->id]) }}"
                                class="text-blue-600 hover:text-blue-800 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0c0 3.866-4.477 7-10 7s-10-3.134-10-7 4.477-7 10-7 10 3.134 10 7z" />
                                </svg>
                            </a>
                            
                            

                            <!-- Delete Button -->
                            <button wire:click="deleteFeedback({{ $feedback->id }})"
                                wire:confirm='Are you sure to delete this record'
                                class="text-red-600 hover:text-red-800 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                </svg>
                            </button>
                        </td>


                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                            No feedback found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $feedbacks->links() }}
        </div>
    </div>
</div>