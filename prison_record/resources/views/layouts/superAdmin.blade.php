<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prison Record Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
    @stack('styles')
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar - Fixed -->
        <div id="sidebar" class="flex-none overflow-y-auto text-gray-300 bg-gray-900 shadow-lg w-72">
            @if (Auth::user()->role === 'superadmin')
            @include('components.superadmin.sidebar')
            @elseif(Auth::user()->role === 'admin')
            @include('components.admin.sidebar')
            @elseif(Auth::user()->role === 'employee')
            @include('components.employee.sidebar')
            @endif
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex flex-col flex-1">
            <!-- Topbar - Fixed -->
            <div class="z-10 bg-white border-b shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <div class="flex items-center">
                        <button id="sidebarToggle"
                            class="p-2 text-gray-600 rounded-lg hover:bg-gray-100 focus:outline-none">
                            <i class="text-xl fas fa-bars"></i>
                        </button>
                        <h2 class="ml-4 text-2xl font-bold text-gray-800">@yield('pageName')</h2>
                    </div>
                    @include('includes.account_settings')
                </div>
            </div>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-8">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('includes.logout_modal')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</body>

</html>