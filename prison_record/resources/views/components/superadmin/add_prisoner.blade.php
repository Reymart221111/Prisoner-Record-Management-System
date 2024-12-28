<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-xl" x-data="{ 
        status: '',
        securityLevel: '',
        showStatusNote: false,
        statusBadgeColor: '',
        photoPreview: null,
        formClass: 'p-8 space-y-12 transition-all duration-300',
        
        initForm() {
            this.$watch('status', value => {
                this.showStatusNote = ['escaped', 'deceased', 'transferred'].includes(value);
                this.updateStatusBadgeColor();
            });
            
            this.$watch('securityLevel', value => {
                this.updateFormAppearance();
            });
        },
        
        updateStatusBadgeColor() {
            const colors = {
                'active': 'bg-green-100 text-green-800',
                'released': 'bg-blue-100 text-blue-800',
                'transferred': 'bg-yellow-100 text-yellow-800',
                'deceased': 'bg-gray-100 text-gray-800',
                'escaped': 'bg-red-100 text-red-800'
            };
            this.statusBadgeColor = colors[this.status] || '';
        },
        
        updateFormAppearance() {
            const baseClasses = 'p-8 space-y-12 transition-all duration-300';
            const securityColors = {
                'minimum': 'border-2 border-green-200',
                'medium': 'border-2 border-yellow-200',
                'maximum': 'border-2 border-orange-200',
                'supermax': 'border-2 border-red-200'
            };
            this.formClass = this.securityLevel ? 
                `${baseClasses} ${securityColors[this.securityLevel]}` : 
                baseClasses;
        }
    }" x-init="initForm">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900">Add New Prisoner</h2>
            <p class="mt-2 text-sm text-gray-500">Enter the prisoner's information in the form below</p>
        </div>

        <form :class="formClass">
            <!-- Two Column Layout for Main Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Personal Information Column -->
                <div class="space-y-8">
                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>

                    <div>
                        <label for="prisoner_id" class="block text-sm font-medium text-gray-700">Prisoner ID<span class="text-red-500">*<span></label>
                        <input type="text" id="prisoner_id" name="prisoner_id"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name<span class="text-red-500">*<span></label>
                            <input type="text" id="first_name" name="first_name"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name<span class="text-red-500">*<span></label>
                            <input type="text" id="last_name" name="last_name"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality<span class="text-red-500">*<span></label>
                        <input type="text" id="nationality" name="nationality"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="height" class="block text-sm font-medium text-gray-700">Height (cm)<span class="text-red-500">*<span></label>
                            <input type="number" id="height" name="height" step="0.1"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="175.5">
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700">Weight (kg)<span class="text-red-500">*<span></label>
                            <input type="number" id="weight" name="weight" step="0.1"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="70.5">
                        </div>
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of
                            Birth<span class="text-red-500">*<span></label>
                        <input type="date" id="date_of_birth" name="date_of_birth"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="sex" class="block text-sm font-medium text-gray-700">Sex<span class="text-red-500">*<span></label>
                        <select id="sex" name="sex"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select sex</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>

                <!-- Case Information Column -->
                <div class="space-y-8">
                    <h3 class="text-lg font-semibold text-gray-900">Case Information</h3>

                    <div>
                        <label for="admission_date" class="block text-sm font-medium text-gray-700">Admission
                            Date<span class="text-red-500">*<span></label>
                        <input type="date" id="admission_date" name="admission_date"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="release_date" class="block text-sm font-medium text-gray-700">Expected Release
                            Date</label>
                        <input type="date" id="release_date" name="release_date"
                            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="cell_block" class="block text-sm font-medium text-gray-700">Cell Block<span class="text-red-500">*<span></label>
                            <input type="text" id="cell_block" name="cell_block"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="cell_number" class="block text-sm font-medium text-gray-700">Cell
                                Number<span class="text-red-500">*<span></label>
                            <input type="text" id="cell_number" name="cell_number"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Information -->
            <div class="border-t pt-8 space-y-8">
                <h3 class="text-lg font-semibold text-gray-900">Security Information</h3>

                <!-- Status Field with Badge -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status<span class="text-red-500">*<span></label>
                    <div class="mt-2 flex items-center space-x-4">
                        <select id="status" name="status" x-model="status"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="released">Released</option>
                            <option value="transferred">Transferred</option>
                            <option value="deceased">Deceased</option>
                            <option value="escaped">Escaped</option>
                        </select>
                        <!-- Status Badge -->
                        <span x-show="status" x-text="status.charAt(0).toUpperCase() + status.slice(1)"
                            :class="statusBadgeColor" class="px-3 py-1 rounded-full text-sm font-medium">
                        </span>
                    </div>
                </div>

                <!-- Status Note (Conditional) -->
                <div x-show="showStatusNote" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0" class="border-t pt-4">
                    <label for="status_note" class="block text-sm font-medium text-gray-700">Status Note<span class="text-red-500">*<span></label>
                    <textarea id="status_note" name="status_note" rows="3"
                        class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Please provide additional details about the status change..."></textarea>
                </div>

                <!-- Security Level with Visual Indicators -->
                <div>
                    <label for="security_level" class="block text-sm font-medium text-gray-700">Security Level<span class="text-red-500">*<span></label>
                    <select id="security_level" name="security_level" x-model="securityLevel" :class="{
            'border-green-300': securityLevel === 'minimum',
            'border-yellow-300': securityLevel === 'medium',
            'border-orange-300': securityLevel === 'maximum',
            'border-red-300': securityLevel === 'supermax'
        }" class="mt-2 w-full rounded-lg shadow-sm focus:ring-blue-500 transition-colors duration-300">
                        <option value="">Select Security Level</option>
                        <option value="minimum">Minimum Security</option>
                        <option value="medium">Medium Security</option>
                        <option value="maximum">Maximum Security</option>
                        <option value="supermax">Super-Maximum Security</option>
                    </select>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="border-t pt-8 space-y-8">
                <h3 class="text-lg font-semibold text-gray-900">Additional Information</h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label for="medical_conditions" class="block text-sm font-medium text-gray-700">Medical
                                Conditions</label>
                            <textarea id="medical_conditions" name="medical_conditions" rows="4"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="List any medical conditions..."></textarea>
                        </div>

                        <div>
                            <label for="current_medications" class="block text-sm font-medium text-gray-700">Current
                                Medications</label>
                            <textarea id="current_medications" name="current_medications" rows="4"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="List current medications..."></textarea>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="emergency_contact" class="block text-sm font-medium text-gray-700">Emergency
                                Contact Name</label>
                            <input type="text" id="emergency_contact" name="emergency_contact"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="emergency_phone" class="block text-sm font-medium text-gray-700">Emergency
                                Contact Phone</label>
                            <input type="tel" id="emergency_phone" name="emergency_phone"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="relationship" class="block text-sm font-medium text-gray-700">Relationship to
                                Prisoner</label>
                            <input type="text" id="relationship" name="relationship"
                                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Replace the existing photo upload section with this: -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prisoner Photo</label>
                            <div class="mt-2">
                                <!-- Preview Area -->
                                <template x-if="photoPreview">
                                    <div class="mb-2">
                                        <img :src="photoPreview" alt="Preview"
                                            class="object-cover rounded-lg h-48 w-full">
                                    </div>
                                </template>

                                <div class="flex justify-center px-6 py-6 border-2 border-gray-300 border-dashed rounded-lg"
                                    :class="{'border-blue-300 bg-blue-50': photoPreview}">
                                    <div class="space-y-2 text-center">
                                        <div class="text-sm text-gray-600">
                                            <label
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span x-text="photoPreview ? 'Change photo' : 'Upload a photo'"></span>
                                                <input type="file" class="sr-only" accept="image/*" @change="const file = $event.target.files[0];
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL(file);">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="border-t pt-8 flex justify-end space-x-4">
                <a href="{{ route('superadmin.prisoners.index') }}"
                    class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 inline-flex items-center transition-colors duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                    Save Prisoner Record
                </button>
            </div>
        </form>
    </div>
</div>