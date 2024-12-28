<div class="relative">
    <div class="flex items-center space-x-4">
        <!-- Account Dropdown -->
        <div class="relative">
            <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none group">
                <!-- Enhanced profile image with hover effect -->
                <div
                    class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-200 transform transition-all duration-200 hover:scale-110 hover:border-indigo-500 hover:shadow-lg">
                    <img src="{{ Auth::user()->imgPath ? asset('storage/' . Auth::user()->imgPath) :  asset('storage/uploads/no-photo/no-photo.png')}}"
                        alt="Profile" class="w-full h-full object-cover">
                </div>
                <span class="text-gray-700 group-hover:text-indigo-600">
                    {{ Auth::user()->username ?? Auth::user()->firstName . ' ' . Auth::user()->lastName }}
                </span>
                <i
                    class="fas fa-chevron-down text-gray-500 text-sm group-hover:text-indigo-600 transition-transform duration-200 group-hover:rotate-180"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdownMenu"
                class="absolute right-0 top-full mt-2 w-60 bg-white rounded-lg shadow-lg py-2 hidden border border-gray-100 transform transition-all duration-200 origin-top-right">
                <!-- User Info -->
                <div class="px-4 py-3 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-200 hover:border-indigo-500 transition-all duration-200">
                            <img src="{{ Auth::user()->imgPath ? asset('storage/' . Auth::user()->imgPath) :  asset('storage/uploads/no-photo/no-photo.png')}}"
                                alt="Profile" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">
                                {{ Auth::user()->username ?? Auth::user()->firstName . ' ' . Auth::user()->lastName }}
                            </p>
                            <p class="text-xs text-gray-500">{{Auth::user()->role}}</p>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                @if(Auth::user()->role === 'superadmin')
                <a href="{{ route('superadmin.update.photo.show') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-image text-gray-500"></i>
                    <span>Update Photo</span>
                </a>
                <a href="{{ route('superadmin.update.account.show') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-cog text-gray-500"></i>
                    <span>Account Settings</span>
                </a>
                <a href="{{ route('superadmin.update.password.show') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-key text-gray-500"></i>
                    <span>Change Password</span>
                </a>
                @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.update.photo.show') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-image text-gray-500"></i>
                    <span>Update Photo</span>
                </a>
                <a href="{{ route('admin.update.account.show') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-cog text-gray-500"></i>
                    <span>Account Settings</span>
                </a>
                <a href="{{ route('admin.update.password.show') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-key text-gray-500"></i>
                    <span>Change Password</span>
                </a>
                @elseif(Auth::user()->role === 'employee')
                <a href="{{ route('employee.update.photo.show') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-image text-gray-500"></i>
                    <span>Update Photo</span>
                </a>
                <a href="{{ route('employee.update.account.show') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-cog text-gray-500"></i>
                    <span>Account Settings</span>
                </a>
                <a href="{{ route('employee.update.password.show') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-key text-gray-500"></i>
                    <span>Change Password</span>
                </a>
                @endif

                <!-- Logout -->
                <div class="border-t border-gray-100 mt-2">
                    <a href="#" onclick="openModal()"
                        class="flex items-center space-x-3 px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>