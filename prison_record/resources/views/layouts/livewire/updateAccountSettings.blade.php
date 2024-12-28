<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Prison Record Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Improved Sidebar -->
        @include('components.superadmin.sidebar')

        <!-- Main Content -->
        <div class="flex-1 ml-1 sidebar-transition">

            <!-- Improved Topbar -->
            <div class="bg-white border-b sticky top-0 z-10 shadow-sm">
                <div class="flex justify-between items-center px-8 py-4">
                    <div class="flex items-center">
                        <button id="sidebarToggle"
                            class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-2xl font-bold text-gray-800 ml-4">@yield('pageName')</h2>
                    </div>

                    <!-- Account Settings Menu -->
                    @include('includes.account_settings')
                </div>
            </div>

            <!--Page Content -->
            <div class="p-8">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <@livewire('account-settings')>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Improved Modal -->
    @include('includes.logout_modal')
    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" defer></script>
</body>

</html>