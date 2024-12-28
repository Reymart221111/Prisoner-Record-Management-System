<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @if (Auth::user()->role === 'superadmin' || Auth::user()->role === 'admin')
    <!-- Prisoners Card -->
    <div
        class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-blue-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-user text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-blue-100 text-sm">Total Serving Prisoners</p>
                <p class="text-white text-2xl font-bold">{{$totalPrisoners}}</p>
            </div>
        </div>
    </div>

    <!-- Staff Card -->
    <div
        class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-green-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-user-shield text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-green-100 text-sm">Diceased Inmates</p>
                <p class="text-white text-2xl font-bold">{{$deceasedInmates}}</p>
            </div>
        </div>
    </div>

    <!-- Indefinite Sentence Card (replacing Active Cases) -->
    <div
        class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-infinity text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-yellow-100 text-sm">Indefinite Sentence</p>
                <p class="text-white text-2xl font-bold">{{$indefiniteSentence}}</p>
            </div>
        </div>
    </div>

    <!-- Releases Card -->
    <div
        class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-red-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-door-open text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-red-100 text-sm">Releases This Month</p>
                <p class="text-white text-2xl font-bold">{{$releasesThisMonth}}</p>
            </div>
        </div>
    </div>

    <!-- High Risk Prisoners Card -->
    <div
        class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-purple-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-exclamation-triangle text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-purple-100 text-sm">High Risk Inmates</p>
                <p class="text-white text-2xl font-bold">{{$highRiskInmates}}</p>
            </div>
        </div>
    </div>

    <!-- Medical Cases Card -->
    <div
        class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-pink-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-heartbeat text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-pink-100 text-sm">Prisoner With Medical Cases</p>
                <p class="text-white text-2xl font-bold">{{$medicalCases}}</p>
            </div>
        </div>
    </div>

    <!-- Parole Hearings Card -->
    <div
        class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-indigo-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-gavel text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-indigo-100 text-sm">Prisoner With Paroles</p>
                <p class="text-white text-2xl font-bold">{{$prisonersWithParole}}</p>
            </div>
        </div>
    </div>

    <!-- Cell Occupancy Card -->
    <div
        class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-teal-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-user-plus text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-teal-100 text-sm">Admissions This Week</p>
                <p class="text-white text-2xl font-bold">{{$admissionsThisWeek}}</p>
            </div>
        </div>
    </div>

    <!-- Transferred Prisoners Card -->
    <div
        class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-orange-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-exchange-alt text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-orange-100 text-sm">Transfers This Month</p>
                <p class="text-white text-2xl font-bold">{{$transfersThisMonth}}</p>
            </div>
        </div>
    </div>

    <!-- Escaped Prisoners Card -->
    <div
        class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-rose-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-running text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-rose-100 text-sm">Escape Attempts YTD</p>
                <p class="text-white text-2xl font-bold">{{$escapeAttemptsYTD}}</p>
            </div>
        </div>
    </div>

    <!-- Foreign Nationals Card -->
    <div
        class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-cyan-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-globe text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-cyan-100 text-sm">Foreign Nationals</p>
                <p class="text-white text-2xl font-bold">{{$foreignNationals}}</p>
            </div>
        </div>
    </div>

    <!-- Security Level Distribution Card -->
    <div
        class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-emerald-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-shield-alt text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-emerald-100 text-sm">Maximum Security</p>
                <p class="text-white text-2xl font-bold">{{$maximumSecurity}}</p>
            </div>
        </div>
    </div>

    {{-- Charts Grid --}}
    <div class="col-span-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <!-- Security Level Distribution Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-lg font-semibold mb-6 text-gray-800 border-b pb-3">
                    <i class="fas fa-chart-pie mr-2 text-blue-500"></i>
                    Security Level Distribution
                </h3>
                <div id="securityLevelChart" class="min-h-[400px]"></div>
            </div>

            <!-- Monthly Admissions Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-lg font-semibold mb-6 text-gray-800 border-b pb-3">
                    <i class="fas fa-chart-line mr-2 text-green-500"></i>
                    Monthly Admissions
                </h3>
                <div id="monthlyAdmissionsChart" class="min-h-[400px]"></div>
            </div>

            <!-- Prisoner Trends Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-lg font-semibold mb-6 text-gray-800 border-b pb-3">
                    <i class="fas fa-chart-bar mr-2 text-purple-500"></i>
                    Prisoner Trends
                </h3>
                <div id="prisonerTrendsChart" class="min-h-[400px]"></div>
            </div>

            <!-- Medical Cases Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-lg font-semibold mb-6 text-gray-800 border-b pb-3">
                    <i class="fas fa-heartbeat mr-2 text-red-500"></i>
                    Top Medical Conditions
                </h3>
                <div id="medicalCasesChart" class="min-h-[400px]"></div>
            </div>
        </div>
    </div>

    <input type="hidden" id="chart-data" wire:ignore value="{{ json_encode($chartData) }}">
    @else
    <!-- Prisoners Card -->
    <div
        class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-blue-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-user text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-blue-100 text-sm">Total Serving Prisoners</p>
                <p class="text-white text-2xl font-bold">{{$totalPrisoners}}</p>
            </div>
        </div>
    </div>

    <!-- Staff Card -->
    <div
        class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-green-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-user-shield text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-green-100 text-sm">Diceased Inmates</p>
                <p class="text-white text-2xl font-bold">{{$deceasedInmates}}</p>
            </div>
        </div>
    </div>

    <!-- Indefinite Sentence Card (replacing Active Cases) -->
    <div
        class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-infinity text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-yellow-100 text-sm">Indefinite Sentence</p>
                <p class="text-white text-2xl font-bold">{{$indefiniteSentence}}</p>
            </div>
        </div>
    </div>

    <!-- Releases Card -->
    <div
        class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-red-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-door-open text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-red-100 text-sm">Releases This Month</p>
                <p class="text-white text-2xl font-bold">{{$releasesThisMonth}}</p>
            </div>
        </div>
    </div>

    <!-- High Risk Prisoners Card -->
    <div
        class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-purple-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-exclamation-triangle text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-purple-100 text-sm">High Risk Inmates</p>
                <p class="text-white text-2xl font-bold">{{$highRiskInmates}}</p>
            </div>
        </div>
    </div>

    <!-- Medical Cases Card -->
    <div
        class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-pink-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-heartbeat text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-pink-100 text-sm">Prisoner With Medical Cases</p>
                <p class="text-white text-2xl font-bold">{{$medicalCases}}</p>
            </div>
        </div>
    </div>

    <!-- Parole Hearings Card -->
    <div
        class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-indigo-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-gavel text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-indigo-100 text-sm">Prisoner With Paroles</p>
                <p class="text-white text-2xl font-bold">{{$prisonersWithParole}}</p>
            </div>
        </div>
    </div>

    <!-- Cell Occupancy Card -->
    <div
        class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-teal-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-user-plus text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-teal-100 text-sm">Admissions This Week</p>
                <p class="text-white text-2xl font-bold">{{$admissionsThisWeek}}</p>
            </div>
        </div>
    </div>

    <!-- Transferred Prisoners Card -->
    <div
        class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-orange-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-exchange-alt text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-orange-100 text-sm">Transfers This Month</p>
                <p class="text-white text-2xl font-bold">{{$transfersThisMonth}}</p>
            </div>
        </div>
    </div>

    <!-- Escaped Prisoners Card -->
    <div
        class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-rose-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-running text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-rose-100 text-sm">Escape Attempts YTD</p>
                <p class="text-white text-2xl font-bold">{{$escapeAttemptsYTD}}</p>
            </div>
        </div>
    </div>

    <!-- Foreign Nationals Card -->
    <div
        class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-cyan-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-globe text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-cyan-100 text-sm">Foreign Nationals</p>
                <p class="text-white text-2xl font-bold">{{$foreignNationals}}</p>
            </div>
        </div>
    </div>

    <!-- Security Level Distribution Card -->
    <div
        class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 transform transition-transform duration-200 hover:scale-105">
        <div class="flex items-center">
            <div class="p-3 bg-emerald-400 bg-opacity-30 rounded-lg mr-4">
                <i class="fas fa-shield-alt text-3xl text-white"></i>
            </div>
            <div>
                <p class="text-emerald-100 text-sm">Maximum Security</p>
                <p class="text-white text-2xl font-bold">{{$maximumSecurity}}</p>
            </div>
        </div>
    </div>
    @endif
</div>