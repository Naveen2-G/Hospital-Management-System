<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Hospital Management System - Quality healthcare services with modern technology.')">
    <title>@yield('title') — HMS Hospital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- 
        Tailwind Safelist for dynamic classes used in Service & Health Package pages:
        bg-rose-50 bg-rose-100 bg-rose-500 text-rose-100 text-rose-200 text-rose-300 text-rose-500 text-rose-600 text-rose-700 from-rose-50 from-rose-500 to-rose-50 to-rose-600 hover:border-rose-200 hover:border-rose-400 border-rose-400 ring-rose-50 shadow-rose-500/20 shadow-rose-500/25 group-hover:text-rose-300
        bg-amber-50 bg-amber-100 bg-amber-500 text-amber-100 text-amber-200 text-amber-300 text-amber-500 text-amber-600 text-amber-700 from-amber-50 from-amber-500 to-amber-50 to-amber-600 hover:border-amber-200 hover:border-amber-400 border-amber-400 ring-amber-50 shadow-amber-500/20 shadow-amber-500/25 group-hover:text-amber-300
        bg-violet-50 bg-violet-100 bg-violet-500 text-violet-100 text-violet-200 text-violet-300 text-violet-500 text-violet-600 text-violet-700 from-violet-50 from-violet-500 to-violet-50 to-violet-600 hover:border-violet-200 hover:border-violet-400 border-violet-400 ring-violet-50 shadow-violet-500/20 shadow-violet-500/25 group-hover:text-violet-300
        bg-sky-50 bg-sky-100 bg-sky-500 text-sky-100 text-sky-200 text-sky-300 text-sky-500 text-sky-600 text-sky-700 from-sky-50 from-sky-500 to-sky-50 to-sky-600 hover:border-sky-200 hover:border-sky-400 border-sky-400 ring-sky-50 shadow-sky-500/20 shadow-sky-500/25 group-hover:text-sky-300
        bg-red-50 bg-red-100 bg-red-500 text-red-100 text-red-200 text-red-300 text-red-500 text-red-600 text-red-700 from-red-50 from-red-500 to-red-50 to-red-600 hover:border-red-200 hover:border-red-400 border-red-400 ring-red-50 shadow-red-500/20 shadow-red-500/25 group-hover:text-red-300
        bg-blue-50 bg-blue-100 bg-blue-500 text-blue-100 text-blue-200 text-blue-300 text-blue-500 text-blue-600 text-blue-700 from-blue-50 from-blue-500 to-blue-50 to-blue-600 hover:border-blue-200 hover:border-blue-400 border-blue-400 ring-blue-50 shadow-blue-500/20 shadow-blue-500/25 group-hover:text-blue-300
        bg-emerald-50 bg-emerald-100 bg-emerald-500 text-emerald-100 text-emerald-200 text-emerald-300 text-emerald-500 text-emerald-600 text-emerald-700 from-emerald-50 from-emerald-500 to-emerald-50 to-emerald-600 hover:border-emerald-200 hover:border-emerald-400 border-emerald-400 ring-emerald-50 shadow-emerald-500/20 shadow-emerald-500/25 group-hover:text-emerald-300
    -->
</head>
<body class="bg-white text-gray-800 font-sans antialiased">
    @include('components.navbar')

    <!-- Page Hero Banner -->
    <section class="relative pt-24 pb-12 lg:pt-28 lg:pb-16 bg-mesh-gradient overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern"></div>
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-gradient-to-br from-primary-200 to-primary-100 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-[400px] h-[400px] bg-gradient-to-tr from-emerald-200 to-emerald-100 rounded-full opacity-20 blur-3xl"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">@yield('page_title')</h1>
            <p class="mt-4 text-gray-500 text-lg max-w-2xl mx-auto">@yield('page_subtitle')</p>
            <div class="mt-4 flex items-center justify-center gap-2 text-sm text-gray-400">
                <a href="/" class="hover:text-primary-500 transition-colors">Home</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-primary-600 font-medium">@yield('breadcrumb')</span>
            </div>
        </div>
    </section>

    @yield('content')

    @include('components.footer')

    {{-- Modals --}}
    @include('components.login-modal')
    @include('components.register-modal')
    @include('components.appointment-modal')
    @include('components.forgot-password-modal')
    @include('components.package-checkout-modal')
    @include('components.special-booking-modal')
</body>
</html>
