<!-- Sticky Navbar -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/80 backdrop-blur-xl border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-2 shrink-0">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div class="hidden sm:block">
                    <span class="text-lg font-bold text-gray-900">HMS</span>
                    <span class="text-xs text-gray-500 block -mt-1 font-medium">Hospital Management</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ url('/') }}" class="px-4 py-2 text-sm font-medium text-primary-600 bg-primary-50 rounded-lg transition-colors">Home</a>
                <a href="{{ route('doctors') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">Doctors</a>
                <a href="{{ route('appointments') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">Appointments</a>
                <a href="{{ route('lab-tests') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">Lab Tests</a>
                <a href="{{ route('about') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">About Us</a>
                <a href="#footer" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">Contact</a>
            </div>

            <!-- Search + Auth -->
            <div class="hidden lg:flex items-center gap-3">
                <!-- Search bar -->
                <form action="{{ route('doctors') }}" method="GET" class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" placeholder="Search doctors, services..." class="w-56 pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all">
                </form>
                <button data-open-modal="login-modal" class="px-5 py-2.5 text-sm font-semibold text-primary-600 border border-primary-200 rounded-xl hover:bg-primary-50 hover:border-primary-400 hover:shadow-md hover:shadow-primary-500/10 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 cursor-pointer">Login</button>
                <button data-open-modal="register-modal" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-md shadow-primary-500/20 hover:shadow-lg hover:shadow-primary-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 cursor-pointer">Register</button>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition-colors" aria-label="Toggle menu">
                <svg class="w-6 h-6 text-gray-700" id="menu-icon-open" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg class="w-6 h-6 text-gray-700 hidden" id="menu-icon-close" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-100 bg-white/95 backdrop-blur-xl">
        <div class="px-4 py-4 space-y-1">
            <a href="{{ url('/') }}" class="block px-4 py-3 text-sm font-medium text-primary-600 bg-primary-50 rounded-xl">Home</a>
            <a href="{{ route('doctors') }}" class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-xl">Doctors</a>
            <a href="{{ route('appointments') }}" class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-xl">Appointments</a>
            <a href="{{ route('lab-tests') }}" class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-xl">Lab Tests</a>
            <a href="{{ route('about') }}" class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-xl">About Us</a>
            <a href="#footer" class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-xl">Contact</a>
        </div>
        <div class="px-4 pb-4 space-y-2">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="Search doctors, services..." class="w-full pl-9 pr-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400">
            </div>
            <div class="flex gap-2">
                <button data-open-modal="login-modal" class="flex-1 px-4 py-3 text-sm font-semibold text-primary-600 border border-primary-200 rounded-xl hover:bg-primary-50 hover:border-primary-400 hover:shadow-md active:scale-95 transition-all duration-200 cursor-pointer">Login</button>
                <button data-open-modal="register-modal" class="flex-1 px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl shadow-md hover:shadow-lg hover:from-primary-600 hover:to-primary-700 active:scale-95 transition-all duration-200 cursor-pointer">Register</button>
            </div>
        </div>
    </div>
</nav>
