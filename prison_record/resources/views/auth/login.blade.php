<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prison Record Management System - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-gray-100 rounded-2xl shadow-lg p-10 text-gray-800">
        <h1 class="text-3xl font-extrabold text-center text-indigo-800 mb-8">Prison Management Login</h1>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-600 mb-2" for="email">Email Address</label>
                <input 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="admin@example.com"
                    required 
                    autofocus>
            </div>
            
            <div class="mb-6" x-data="{ showPassword: false }">
                <label class="block text-sm font-semibold text-gray-600 mb-2" for="password">Password</label>
                <div class="relative">
                    <input 
                        :type="showPassword ? 'text' : 'password'" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password"
                        required>
                    
                    <!-- Toggle Button -->
                    <button type="button" @click="showPassword = !showPassword" 
                        class="absolute inset-y-0 right-3 flex items-center text-gray-600 hover:text-gray-800 focus:outline-none">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.94 10.94a10.48 10.48 0 0114.12 0 1 1 0 11-1.41 1.41A8.48 8.48 0 004.35 10.35a1 1 0 111.41-1.41z"/>
                            <path d="M14.12 4.12a1 1 0 011.41 1.41A8.48 8.48 0 0011.88 6a1 1 0 010-2 10.48 10.48 0 012.24.12z"/>
                        </svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 4a7.99 7.99 0 017.99 7.99A7.99 7.99 0 0110 20a7.99 7.99 0 01-7.99-7.99A7.99 7.99 0 0110 4zm0 2a6 6 0 100 12 6 6 0 000-12zM7 10a3 3 0 016 0 3 3 0 01-6 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button 
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-400" 
                type="submit">
                Login
            </button>
        </form>
    </div>
    @livewireScripts
</body>
</html>
