<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — HMS Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="theme-gray-dark bg-gray-50 font-sans antialiased min-h-screen">

    @php use Illuminate\Support\Facades\Auth; @endphp
    @php
        $isActiveTab = fn (string $pattern) => request()->routeIs($pattern);
    @endphp

    {{-- ═══ Top Header ════════════════════════════════════════ --}}
    <header class="admin-header">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 shrink-0 group hover:opacity-80 transition-all duration-200">
                    <div class="w-10 h-10 bg-linear-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-bold bg-linear-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">HMS</span>
                        <span class="text-[10px] text-slate-500 block leading-none mt-0.5 font-medium">Admin</span>
                    </div>
                </a>

                {{-- Search --}}
                <div class="hidden md:block relative">
                    <form action="{{ route('admin.search') }}" method="GET">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input id="admin-search" type="text" name="q" value="{{ request('q') }}" placeholder="Search... (Ctrl+K)" class="admin-search">
                    </form>
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2">
                    {{-- Notifications --}}
                    <div class="relative">
                        <button id="notif-btn" class="relative p-2.5 rounded-lg hover:bg-slate-100 transition-all duration-200 cursor-pointer group" title="Notifications">
                            <svg class="w-5 h-5 text-slate-600 group-hover:text-slate-800 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                            </svg>
                            @php $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count(); @endphp
                            @if($unreadCount > 0)
                                <span class="notif-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </button>
                        {{-- Notification Dropdown --}}
                        <div id="notif-dropdown" class="dropdown-menu hidden" style="min-width: 320px;">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                @php $notifications = \App\Models\Notification::where('user_id', Auth::id())->orderByDesc('created_at')->limit(5)->get(); @endphp
                                @forelse($notifications as $notif)
                                    <div class="dropdown-item {{ $notif->is_read ? 'opacity-60' : '' }}">
                                        <div class="w-2 h-2 rounded-full shrink-0 {{ $notif->is_read ? 'bg-gray-300' : 'bg-primary-500' }}"></div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $notif->title }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $notif->message }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-sm text-gray-400">No notifications</div>
                                @endforelse
                            </div>
                            <a href="{{ route('admin.notifications.index') }}" class="block text-center text-xs font-medium text-primary-600 py-2.5 border-t border-gray-100 hover:bg-gray-50">View all</a>
                        </div>
                    </div>

                    {{-- User Menu --}}
                    <div class="relative">
                        <button id="user-menu-btn" class="flex items-center gap-2.5 pl-2.5 pr-2 py-1.5 rounded-lg hover:bg-slate-100 transition-all duration-200 cursor-pointer group">
                            <div class="w-8 h-8 bg-linear-to-br from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-md group-hover:shadow-lg transition-all">
                                {{ strtoupper(substr(Auth::user()->name ?? '', 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-semibold text-slate-800 leading-none">{{ Auth::user()->name ?? '' }}</p>
                                <p class="text-[11px] text-slate-500 leading-none mt-0.5">Administrator</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-600 group-hover:text-slate-800 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="user-dropdown" class="dropdown-menu hidden">
                            <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Settings
                            </a>
                            <a href="{{ route('admin.audit-logs.index') }}" class="dropdown-item">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                                Audit Logs
                            </a>
                            <button type="button" id="change-password-btn" class="dropdown-item w-full text-left">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.973m3.029-5.973a3 3 0 11-6 0 3 3 0 016 0zm6 0a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                                Change Password
                            </button>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-left text-red-600 hover:bg-red-50 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ═══ Tab Navigation ════════════════════════════════════ --}}
    <nav class="admin-tab-nav">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Desktop Tabs --}}
            <div class="hidden lg:flex items-center tab-scroll overflow-x-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
                <style>
                    .tab-scroll::-webkit-scrollbar { display: none; }
                </style>
                <a href="{{ route('admin.dashboard') }}" class="admin-tab {{ $isActiveTab('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.patients.index') }}" class="admin-tab {{ $isActiveTab('admin.patients.*') ? 'active' : '' }}">Patients</a>
                <a href="{{ route('admin.accounts.index') }}" class="admin-tab {{ $isActiveTab('admin.accounts.*') ? 'active' : '' }}">Accounts</a>
                <a href="{{ route('admin.doctors.index') }}" class="admin-tab {{ $isActiveTab('admin.doctors.*') ? 'active' : '' }}">Doctors</a>
                <a href="{{ route('admin.appointments.index') }}" class="admin-tab {{ $isActiveTab('admin.appointments.*') ? 'active' : '' }}">Appointments</a>
                <a href="{{ route('admin.admissions.index') }}" class="admin-tab {{ $isActiveTab('admin.admissions.*') ? 'active' : '' }}">OPD / IPD</a>
                <a href="{{ route('admin.rooms.index') }}" class="admin-tab {{ $isActiveTab('admin.rooms.*') ? 'active' : '' }}">Rooms</a>
                <a href="{{ route('admin.pharmacy.index') }}" class="admin-tab {{ $isActiveTab('admin.pharmacy.*') ? 'active' : '' }}">Pharmacy</a>
                <a href="{{ route('admin.lab-tests.index') }}" class="admin-tab {{ $isActiveTab('admin.lab-tests.*') ? 'active' : '' }}">Laboratory</a>
                <a href="{{ route('admin.billing.index') }}" class="admin-tab {{ $isActiveTab('admin.billing.*') ? 'active' : '' }}">Billing</a>
                <a href="{{ route('admin.staff.index') }}" class="admin-tab {{ $isActiveTab('admin.staff.*') ? 'active' : '' }}">Staff</a>
                <a href="{{ route('admin.reports.index') }}" class="admin-tab {{ $isActiveTab('admin.reports.*') ? 'active' : '' }}">Reports</a>
                <a href="{{ route('admin.settings.index') }}" class="admin-tab {{ $isActiveTab('admin.settings.*') ? 'active' : '' }}">Settings</a>
            </div>

            {{-- Mobile Tab Button --}}
            <div class="lg:hidden py-2">
                <button id="mobile-tab-btn" class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-linear-to-r from-slate-100 to-slate-50 text-sm font-semibold text-slate-700 w-full cursor-pointer hover:from-slate-200 hover:to-slate-100 transition-all duration-200 border border-slate-200 hover:border-slate-300">
                    <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                    <span>@yield('title', 'Dashboard')</span>
                    <svg class="w-4 h-4 ml-auto text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="mobile-tab-menu" class="hidden mt-2 bg-linear-to-b from-white to-slate-50 rounded-xl border border-slate-200 shadow-lg p-2 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.dashboard') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Dashboard</a>
                    <a href="{{ route('admin.patients.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.patients.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Patients</a>
                    <a href="{{ route('admin.accounts.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.accounts.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Accounts</a>
                    <a href="{{ route('admin.doctors.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.doctors.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Doctors</a>
                    <a href="{{ route('admin.appointments.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.appointments.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Appointments</a>
                    <a href="{{ route('admin.admissions.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.admissions.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">OPD / IPD</a>
                    <a href="{{ route('admin.rooms.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.rooms.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Rooms</a>
                    <a href="{{ route('admin.pharmacy.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.pharmacy.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Pharmacy</a>
                    <a href="{{ route('admin.lab-tests.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.lab-tests.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Laboratory</a>
                    <a href="{{ route('admin.billing.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.billing.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Billing</a>
                    <a href="{{ route('admin.staff.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.staff.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Staff</a>
                    <a href="{{ route('admin.reports.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.reports.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Reports</a>
                    <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActiveTab('admin.settings.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">Settings</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ═══ Main Content ══════════════════════════════════════ --}}
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 page-enter">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-linear-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl flex items-center gap-3 shadow-sm hover:shadow-md transition-shadow">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- ═══ Footer ════════════════════════════════════════════ --}}
    <footer class="border-t border-slate-200 py-6 mt-12 bg-linear-to-b from-white to-slate-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-xs text-slate-500 font-medium">&copy; {{ date('Y') }} HMS Hospital &middot; Admin Panel &middot; v1.0</p>
        </div>
    </footer>

    {{-- Toast Container --}}
    <div id="toast-container" class="toast-container"></div>

    {{-- Change Password Modal --}}
    <div id="change-password-modal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center backdrop-blur-sm" data-route="{{ route('admin.change-password.update') }}" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-8 animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Change Password</h2>
                <button type="button" id="close-password-modal" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="change-password-form" class="space-y-5">
                @csrf

                {{-- Current Password --}}
                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required
                        class="form-input focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your current password">
                    <span class="hidden text-red-600 text-sm mt-1" id="current_password_error"></span>
                </div>

                {{-- New Password --}}
                <div class="form-group">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" id="new_password" name="new_password" required
                        class="form-input focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your new password">
                    <p class="text-xs text-slate-500 mt-1">At least 8 characters with uppercase, lowercase, and number</p>
                    <span class="hidden text-red-600 text-sm mt-1" id="new_password_error"></span>
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                        class="form-input focus:ring-2 focus:ring-blue-500"
                        placeholder="Confirm your new password">
                    <span class="hidden text-red-600 text-sm mt-1" id="confirm_password_error"></span>
                </div>

                {{-- Submit --}}
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Update Password
                    </button>
                    <button type="button" id="cancel-password-modal" class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
