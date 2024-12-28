<aside id="sidebar" class="w-72 bg-gray-900 text-gray-300 min-h-screen shadow-lg sidebar-transition"
    x-data="{ showCrimesSubMenu: {{ request()->routeIs('admin.crimes.*') ? 'true' : 'false' }} }">
    <div class="p-6">
        <div class="flex items-center space-x-3 mb-10">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-jail text-white text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wider">Prison Record</h1>
        </div>

        <nav class="space-y-1">
            <a href="{{route('admin.dashboard')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{route('admin.prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.prisoners.index', 'admin.prisoners.*']) }}">
                <i class="fas fa-users w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Prisoners</span>
            </a>
            <div class="relative" @click="showCrimesSubMenu = !showCrimesSubMenu">
                <a href="#"
                    class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.crimes.index', 'admin.crimes.*']) }}">
                    <i class="fas fa-balance-scale w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                    <span>Crimes</span>
                    <i class="fas fa-chevron-down ml-auto" :class="{ 'transform rotate-180': showCrimesSubMenu }"></i>
                </a>
                <div class="absolute z-10 w-full bg-gray-800 rounded-lg shadow-lg" x-cloak x-show="showCrimesSubMenu">
                    <a href="{{route('admin.crimes.index')}}"
                        class="flex items-center px-4 py-3 hover:bg-gray-700 transition-colors duration-200 {{ isActive(['admin.crimes.index', 'admin.crimes.create', 'admin.crimes.search']) }}">
                        <i class="fas fa-list w-5 h-5 mr-3"></i>
                        <span>Manage Crimes list</span>
                    </a>
                    <a href="{{route('admin.crimes.prisoner-crimes.index')}}"
                        class="flex items-center px-4 py-3 hover:bg-gray-700 transition-colors duration-200 {{isActive(['admin.crimes.prisoner-crimes.index', 'admin.crimes.prisoner-crimes*'])}}">
                        <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                        <span>Prisoner Crimes Record</span>
                    </a>
                </div>

            </div>
            <a href="{{route('admin.medical-records.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.medical-records.index', 'admin.medical-records.*']) }}">
                <i class="fas fa-file-medical w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Prisoner Medical Records</span>
            </a>
            <a href="{{route('admin.prisoner-paroles.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.prisoner-paroles.index', 'admin.prisoner-paroles.*']) }}">
                <i class="fas fa-unlock w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Prisoner Paroles</span>
            </a>
            <a href="{{route('admin.escape-prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.escape-prisoners.index', 'admin.escape-prisoners.*']) }}">
                <i class="fas fa-running w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Escape Inmates</span>
            </a>
            <a href="{{route('admin.disease-prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.disease-prisoners.index', 'admin.disease-prisoners.*']) }}">
                <i class="fas fa-skull-crossbones w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Deceased Inmates</span>
            </a>
            <a href="{{route('admin.transfered-prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.transfered-prisoners.index', 'admin.transfered-prisoners.*']) }}">
                <i class="fas fa-exchange-alt w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Transferred Inmates</span>
            </a>
            <a href="{{route('admin.released-prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.released-prisoners.index', 'admin.released-prisoners.*']) }}">
                <i class="fas fa-door-open w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Released Inmates</span>
            </a>
            <a href="{{route('admin.user-management.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.user-management.index', 'admin.user-management.*']) }}">
                <i class="fas fa-user-shield w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>User Roles and Permissions</span>
            </a>
            <a href="{{route('admin.help.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.help.index', 'admin.help.*']) }}">
                <i class="fas fa-question-circle w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>System Help</span>
            </a>
            <a href="{{route('admin.audit.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.audit.index', 'admin.audit.*']) }}">
                <i class="fas fa-clipboard-check w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Audit Logs</span>
            </a>
            <a href="{{route('admin.about.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.about.index', 'admin.about.*']) }}">
                <i class="fas fa-info-circle w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>About Page</span>
            </a>
            <a href="{{route('admin.feedbacks.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['admin.feedbacks.index', 'admin.feedbacks.*']) }}">
                <i class="fas fa-comments w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>User Feedbacks</span>
            </a>
        </nav>
    </div>
</aside>