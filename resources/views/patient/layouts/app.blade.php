<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Patient Portal') — HMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/patient.css', 'resources/js/patient.js'])
</head>
<body class="patient-shell font-sans antialiased">
    <header class="patient-header">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('patient.dashboard') }}" class="flex items-center gap-3 group">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 shadow-lg shadow-emerald-600/20 transition group-hover:shadow-emerald-600/30 group-hover:scale-105">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/></svg>
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-extrabold tracking-tight text-slate-900">HMS Hospital</div>
                    <div class="text-xs font-semibold text-emerald-600">Patient Portal</div>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ route('patient.change-password.edit') }}" class="patient-pill">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                   Change Password
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="patient-pill patient-logout-btn">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="relative z-[1] mx-auto max-w-6xl px-4 pb-16 pt-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="patient-alert patient-alert-success">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="patient-alert patient-alert-error">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="patient-footer">
        <div class="mx-auto max-w-6xl px-4 py-8 text-center text-xs font-medium text-slate-400 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-1.5 mb-1">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                <span>HMS Hospital Management System</span>
            </div>
            © {{ date('Y') }} — Patient Portal · All rights reserved
        </div>
    </footer>
</body>
</html>
