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
        <div class="flex w-full items-center justify-between gap-4 px-6 py-3">
            <a href="{{ route('patient.dashboard') }}" class="flex items-center gap-3 group">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 shadow-lg shadow-emerald-600/20 transition group-hover:shadow-emerald-600/30 group-hover:scale-105">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/></svg>
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-extrabold tracking-tight text-slate-900">HMS Hospital</div>
                    <div class="text-xs font-semibold text-emerald-600">Patient Portal</div>
                </div>
            </a>

            @include('patient.partials.topnav')

            <div class="flex items-center gap-2">
                {{-- Notification Bell --}}
                @php
                    $notifItems = collect();
                    if(isset($appointments)) foreach($appointments->take(3) as $apt) {
                        $notifItems->push(['color'=>'blue','msg'=>'Appointment with Dr. '.($apt->doctor?->name ?? 'doctor').' on '.optional($apt->appointment_date)->format('d M'),'time'=>optional($apt->created_at)->diffForHumans()]);
                    }
                    if(isset($labOrders)) foreach($labOrders->whereNotNull('report_file')->take(2) as $lo) {
                        $notifItems->push(['color'=>'green','msg'=>'Lab report ready: '.($lo->labTest?->name ?? 'Lab test'),'time'=>optional($lo->ordered_at)->diffForHumans()]);
                    }
                    if(isset($invoices)) foreach($invoices->where('status','paid')->take(1) as $inv) {
                        $notifItems->push(['color'=>'amber','msg'=>'Payment confirmed for invoice '.($inv->invoice_number ?? '#'.$inv->id),'time'=>optional($inv->updated_at)->diffForHumans()]);
                    }
                    if(isset($prescriptions)) foreach($prescriptions->take(1) as $rx) {
                        $notifItems->push(['color'=>'violet','msg'=>'Prescription issued by Dr. '.($rx->doctor?->name ?? 'doctor'),'time'=>optional($rx->created_at)->diffForHumans()]);
                    }
                @endphp
                <div class="notif-bell-wrap" id="notif-bell-wrap">
                    <button class="notif-bell-btn" id="notif-bell-btn" aria-label="Notifications">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($notifItems->count() > 0)
                            <span class="notif-badge">{{ $notifItems->count() }}</span>
                        @endif
                    </button>
                    <div class="notif-dropdown" id="notif-dropdown">
                        <div class="notif-dropdown-header">
                            <h3>Notifications</h3>
                            <span class="notif-mark-read" id="notif-mark-read">Mark all read</span>
                        </div>
                        <div class="notif-list">
                            @if($notifItems->isEmpty())
                                <div style="padding:1.5rem;text-align:center;color:#94a3b8;font-size:0.82rem;font-weight:600">No notifications yet.</div>
                            @else
                                @foreach($notifItems as $n)
                                <div class="notif-item unread">
                                    <div class="notif-icon {{ $n['color'] }}">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="notif-text">
                                        <p>{{ $n['msg'] }}</p>
                                        <span>{{ $n['time'] }}</span>
                                    </div>
                                    <div class="notif-dot"></div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('patient.profile') }}" class="patient-pill">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    Profile
                </a>
                <a href="{{ route('patient.change-password.edit') }}" class="patient-pill">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                    Password
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

    <main class="relative z-[1] w-full px-6 pb-16 pt-6">
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
        <div class="w-full px-6 py-8 text-center text-xs font-medium text-slate-400">
            <div class="flex items-center justify-center gap-1.5 mb-1">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                <span>HMS Hospital Management System</span>
            </div>
            © {{ date('Y') }} — Patient Portal · All rights reserved
        </div>
    </footer>
    {{-- Emergency SOS Floating Button --}}
    @php $sosNumber = isset($patient) ? ($patient->emergency_contact ?? '') : ''; @endphp
    <a href="tel:{{ $sosNumber ?: '108' }}" class="sos-btn" id="sos-btn" title="Emergency SOS" aria-label="Emergency SOS call">
        <span class="sos-tooltip">{{ $sosNumber ? 'Call '.$sosNumber : 'Emergency: 108' }}</span>
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
    </a>

    <script>
        // Notification bell toggle
        const bellBtn = document.getElementById('notif-bell-btn');
        const bellDrop = document.getElementById('notif-dropdown');
        if (bellBtn && bellDrop) {
            bellBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                bellDrop.classList.toggle('open');
            });
            document.addEventListener('click', () => bellDrop.classList.remove('open'));
            bellDrop.addEventListener('click', e => e.stopPropagation());
        }
        const markRead = document.getElementById('notif-mark-read');
        if (markRead) {
            markRead.addEventListener('click', () => {
                document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
                const badge = document.querySelector('.notif-badge');
                if (badge) badge.remove();
            });
        }
    </script>
</body>
</html>
