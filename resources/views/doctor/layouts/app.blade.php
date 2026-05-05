<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Doctor Dashboard') — HMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/js/doctor.js'])
</head>
<body class="min-h-screen font-sans bg-slate-50 text-slate-900 antialiased" style="background: radial-gradient(circle at top left, rgba(59,130,246,0.10), transparent 28%), radial-gradient(circle at top right, rgba(14,165,233,0.08), transparent 30%), linear-gradient(140deg, #f8fafc 0%, #f3f7ff 52%, #f8fafc 100%);">
    @php use Illuminate\Support\Facades\Auth; @endphp

    @php
        $user = Auth::user();
        $doctorName = $doctor?->name ?? $user->name ?? 'Doctor';
        $specialization = $doctor?->specialization ?? 'General Practice';
        $qualification = $doctor?->qualification ?? 'Clinical Practitioner';
        $departmentName = $doctor?->department?->name ?? 'Core care team';
        $unreadCount = $user ? $user->notifications()->where('is_read', false)->count() : 0;
        $changePasswordErrors = $errors->changePassword ?? null;
        $profileDetails = [
            'name' => $doctorName,
            'specialization' => $specialization,
            'qualification' => $qualification,
            'department' => $departmentName,
            'phone' => $doctor?->phone ?? 'Not provided',
            'email' => $doctor?->email ?? $user->email ?? '—',
        ];
    @endphp

    <div class="min-h-screen">
        <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/85 backdrop-blur-xl shadow-sm">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <a href="{{ route('doctor.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-linear-to-br from-cyan-500 via-sky-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/25">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold tracking-[0.24em] text-sky-600 uppercase">HMS Doctor Portal</p>
                            <h1 class="text-lg sm:text-xl font-bold text-slate-900 leading-tight">@yield('title', 'Doctor Dashboard')</h1>
                        </div>
                    </a>

                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold text-slate-900">{{ $doctorName }}</p>
                            <p class="text-xs text-slate-500">{{ $specialization }} · {{ now()->format('D, M d') }}</p>
                        </div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                            Active
                        </div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700">
                            {{ $unreadCount }} alerts
                        </div>
                        <div class="relative">
                            <button
                                type="button"
                                data-doctor-profile-toggle
                                class="group inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm transition hover:border-sky-200 hover:bg-sky-50"
                            >
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-linear-to-br from-sky-500 to-blue-600 text-sm font-bold text-white shadow-sm">
                                    {{ strtoupper(mb_substr($doctorName, 0, 1)) }}
                                </span>
                                <span class="hidden md:block text-left">
                                    <span class="block text-xs font-semibold text-slate-900">Profile</span>
                                    <span class="block text-[11px] text-slate-500">{{ $departmentName }}</span>
                                </span>
                                <svg class="h-4 w-4 text-slate-400 transition group-hover:text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div data-doctor-profile-menu class="absolute right-0 top-full z-40 mt-3 hidden w-64 overflow-hidden rounded-3xl border border-slate-200 bg-white p-2 shadow-2xl shadow-slate-900/15">
                                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                    <p class="text-sm font-semibold text-slate-900">{{ $doctorName }}</p>
                                    <p class="text-xs text-slate-500">{{ $specialization }}</p>
                                </div>
                                <button type="button" data-doctor-password-open class="mt-2 flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-700">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.125 4.125 0 10-8.25 0V10.5m8.25 0a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0116.5 19.5h-9A2.25 2.25 0 015.25 17.25v-4.5A2.25 2.25 0 017.5 10.5m9 0h-9"/>
                                    </svg>
                                    Change Password
                                </button>
                                <button type="button" data-doctor-profile-open class="mt-1 flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-700">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0"/>
                                    </svg>
                                    View Profile
                                </button>
                                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-rose-700 hover:bg-rose-50">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200/80 bg-linear-to-r from-white via-sky-50/40 to-white">
                <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
                    <nav class="flex items-center gap-2 overflow-x-auto py-3" style="scrollbar-width: none; -ms-overflow-style: none;">
                        <style>
                            nav::-webkit-scrollbar { display: none; }
                        </style>
                        @foreach($sidebarItems as $index => $item)
                            <a href="{{ $item['href'] }}" data-doctor-nav-link class="doctor-nav-link group inline-flex shrink-0 items-center gap-2 rounded-xl border border-transparent bg-white/70 px-3 py-2 text-sm font-semibold text-slate-600 hover:border-sky-200 hover:bg-sky-50 hover:text-sky-700 transition-all duration-200 {{ $index === 0 ? 'is-active border-sky-200 bg-sky-50 text-sky-700 underline decoration-2 decoration-sky-500 underline-offset-8 shadow-sm' : '' }}">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                                </svg>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </header>

        <main class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        <div id="doctor-password-modal" class="{{ $changePasswordErrors && $changePasswordErrors->any() ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center bg-slate-950/55 px-4 backdrop-blur-sm">
            <div class="w-full max-w-lg rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-2xl">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Security</p>
                        <h2 class="mt-1 text-2xl font-bold text-slate-900">Change Password</h2>
                    </div>
                    <button type="button" data-doctor-password-close class="rounded-full bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">Close</button>
                </div>

                <form method="POST" action="{{ route('doctor.change-password.update') }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label class="form-label" for="doctor_current_password">Current Password</label>
                        <input id="doctor_current_password" type="password" name="current_password" class="form-input" required>
                        @if($changePasswordErrors?->has('current_password'))
                            <p class="mt-1 text-sm text-rose-600">{{ $changePasswordErrors->first('current_password') }}</p>
                        @endif
                    </div>
                    <div>
                        <label class="form-label" for="doctor_new_password">New Password</label>
                        <input id="doctor_new_password" type="password" name="new_password" class="form-input" required>
                        @if($changePasswordErrors?->has('new_password'))
                            <p class="mt-1 text-sm text-rose-600">{{ $changePasswordErrors->first('new_password') }}</p>
                        @endif
                    </div>
                    <div>
                        <label class="form-label" for="doctor_confirm_password">Confirm Password</label>
                        <input id="doctor_confirm_password" type="password" name="confirm_password" class="form-input" required>
                        @if($changePasswordErrors?->has('confirm_password'))
                            <p class="mt-1 text-sm text-rose-600">{{ $changePasswordErrors->first('confirm_password') }}</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" data-doctor-password-close class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Update Password</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="doctor-profile-modal" class="fixed inset-0 z-50 hidden bg-slate-950/55 px-4 backdrop-blur-sm" style="display: none;">
            <div class="w-full max-w-2xl rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-2xl" style="margin: auto; display: flex; flex-direction: column;">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Profile</p>
                        <h2 class="mt-1 text-2xl font-bold text-slate-900">Doctor Details</h2>
                    </div>
                    <button type="button" data-doctor-profile-close class="rounded-full bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">Close</button>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4 sm:col-span-2">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Name</p>
                        <p class="mt-2 text-lg font-semibold text-slate-900">{{ $profileDetails['name'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Specialization</p>
                        <p class="mt-2 font-semibold text-slate-900">{{ $profileDetails['specialization'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Qualification</p>
                        <p class="mt-2 font-semibold text-slate-900">{{ $profileDetails['qualification'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Department</p>
                        <p class="mt-2 font-semibold text-slate-900">{{ $profileDetails['department'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Phone Number</p>
                        <p class="mt-2 font-semibold text-slate-900">{{ $profileDetails['phone'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4 sm:col-span-2">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Email</p>
                        <p class="mt-2 font-semibold text-slate-900">{{ $profileDetails['email'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
