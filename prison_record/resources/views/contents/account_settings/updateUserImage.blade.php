@extends('layouts.superAdmin')

@section('pageName')
Update Profile Image
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-lg p-8 space-y-6">
        <div class="border-b pb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Update Profile Image</h2>
            <p class="text-gray-600 mt-1">Choose a new profile piture for your account</p>
        </div>

        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-red-700 font-medium">Please correct the following errors:</span>
            </div>
            <ul class="mt-2 list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form @if(Auth::user()->role === 'superadmin')
            action="{{ route('superadmin.update.photo') }}"
            @elseif(Auth::user()->role === 'admin')
            action="{{ route('admin.update.photo') }}"
            @elseif(Auth::user()->role === 'employee')
            action="{{ route('employee.update.photo') }}"
            @endif method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('put')

            <div class="space-y-4">
                <!-- Current Profile Preview -->
                <div class="flex justify-center">
                    <div class="relative">
                        <img id="preview"
                            src="{{ asset('storage/' . Auth::user()->imgPath) ?? asset('images/default-avatar.png') }}"
                            class="w-32 h-32 rounded-full object-cover border-4 border-gray-200" alt="Profile Preview">
                        <div class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- File Upload -->
                <div class="flex flex-col items-center">
                    <label for="profile_image"
                        class="w-full max-w-lg flex flex-col items-center px-4 py-6 bg-white rounded-lg shadow-lg tracking-wide border border-blue-500 cursor-pointer hover:bg-blue-50 transition duration-300">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                        </svg>
                        <span class="mt-2 text-sm text-gray-600">Select a file</span>
                        <input type="file" id="profile_image" name="profile_image" class="hidden" accept="image/*">
                    </label>
                    <p class="text-xs text-gray-500 mt-2">Supported formats: JPG, PNG, GIF (Max. 2MB)</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center pt-4">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                    </svg>
                    <span>Update Profile Image</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection