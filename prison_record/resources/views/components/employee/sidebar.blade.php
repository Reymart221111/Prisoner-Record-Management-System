<aside id="sidebar" class="w-72 bg-gray-900 text-gray-300 min-h-screen shadow-lg sidebar-transition">
    <div class="p-6">
        <div class="flex items-center space-x-3 mb-10">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-jail text-white text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wider">Prison Record</h1>
        </div>

        <nav class="space-y-1">
            <a href="{{route('employee.dashboard')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive('employee.dashboard') }}">
                <i class="fas fa-tachometer-alt w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{route('employee.prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.prisoners.index', 'employee.prisoners.*']) }}">
                <i class="fas fa-users w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Prisoners</span>
            </a>
            <a href="{{route('employee.crimes.prisoner-crimes.index')}}"
                class="flex items-center px-4 py-3 hover:bg-gray-700 transition-colors duration-200 {{isActive(['employee.crimes.prisoner-crimes.index', 'employee.crimes.prisoner-crimes*'])}}">
                <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                <span>Prisoner Crimes Record</span>
            </a>
            <a href="{{route('employee.medical-records.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.medical-records.index', 'employee.medical-records.*']) }}">
                <i class="fas fa-file-medical w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Prisoner Medical Records</span>
            </a>
            <a href="{{route('employee.prisoner-paroles.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.prisoner-paroles.index', 'employee.prisoner-paroles.*']) }}">
                <i class="fas fa-unlock w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Prisoner Paroles</span>
            </a>
            <a href="{{route('employee.escape-prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.escape-prisoners.index', 'employee.escape-prisoners.*']) }}">
                <i class="fas fa-running w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Escape Inmates</span>
            </a>
            <a href="{{route('employee.disease-prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.disease-prisoners.index', 'employee.disease-prisoners.*']) }}">
                <i class="fas fa-skull-crossbones w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Deceased Inmates</span>
            </a>
            <a href="{{route('employee.transfered-prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.transfered-prisoners.index', 'employee.transfered-prisoners.*']) }}">
                <i class="fas fa-exchange-alt w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Transferred Inmates</span>
            </a>
            <a href="{{route('employee.released-prisoners.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.released-prisoners.index', 'employee.released-prisoners.*']) }}">
                <i class="fas fa-door-open w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Released Inmates</span>
            </a>
            <a href="{{route('employee.about.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.about.index', 'employee.about.*']) }}">
                <i class="fas fa-info-circle w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>About Page</span>
            </a>
            <a href="{{route('employee.help.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.help.index', 'employee.help.*']) }}">
                <i class="fas fa-question-circle w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>System Help</span>
            </a>
            <a href="{{route('employee.feedbacks.index')}}"
                class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 {{ isActive(['employee.feedbacks.index', 'employee.feedbacks.*']) }}">
                <i class="fas fa-comments w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Submit Feedback</span>
            </a>
        </nav>
    </div>
</aside>