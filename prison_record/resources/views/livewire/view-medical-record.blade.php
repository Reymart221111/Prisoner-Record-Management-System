<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                Medical Record Details
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Detailed view of patient's medical information
            </p>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <!-- Medical Records Grid -->
            <dl class="divide-y divide-gray-200">
                <!-- Medical Diagnosis -->
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-600">
                        Medical Diagnosis
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ $prisonerMedicalRecords->medical_diagnosis ?? 'No diagnosis recorded' }}
                    </dd>
                </div>

                <!-- Medication -->
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-600">
                        Medication
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {!! nl2br(e($prisonerMedicalRecords->medication ?? 'No medication prescribed')) !!}
                    </dd>
                </div>

                <!-- Last Checkup Date -->
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-600">
                        Last Checkup Date
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ \Carbon\Carbon::parse($prisonerMedicalRecords->last_checkup_date)->format('F d, Y') }}
                    </dd>
                </div>

                <!-- Doctor Notes -->
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-600">
                        Doctor Notes
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div class="prose prose-sm max-w-none">
                            {{ $prisonerMedicalRecords->doctor_notes ?? 'No notes available' }}
                        </div>
                    </dd>
                </div>

                <!-- Created At -->
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-600">
                        Record Created
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ \Carbon\Carbon::parse($prisonerMedicalRecords->created_at)->format('F d, Y h:i A') }}
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <button type="button" x-data @click="window.history.go(-1)"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Records
            </button>
        </div>
    </div>
</div>