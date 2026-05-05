<!-- Hero Section -->
<section id="home" class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden bg-mesh-gradient">
    <!-- Background decoration -->
    <div class="absolute inset-0 bg-grid-pattern"></div>
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-gradient-to-br from-primary-200 to-primary-100 rounded-full opacity-25 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-gradient-to-tr from-emerald-200 to-emerald-100 rounded-full opacity-25 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[900px] bg-gradient-to-br from-primary-50 to-emerald-50 rounded-full opacity-30 blur-3xl"></div>
        <!-- Extra subtle floating shapes -->
        <div class="absolute top-20 left-1/4 w-4 h-4 bg-primary-300 rounded-full opacity-20 animate-float"></div>
        <div class="absolute top-40 right-1/3 w-3 h-3 bg-emerald-300 rounded-full opacity-20 animate-float animation-delay-200"></div>
        <div class="absolute bottom-32 left-1/3 w-5 h-5 bg-violet-200 rounded-full opacity-15 animate-float animation-delay-400"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-center lg:text-left animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 border border-primary-100 rounded-full text-primary-700 text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    Trusted by 10,000+ patients
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight tracking-tight">
                    Book Appointments with
                    <span class="bg-gradient-to-r from-primary-500 to-emerald-500 bg-clip-text text-transparent">Trusted Doctors</span>
                </h1>

                <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Search doctors, book appointments, and manage health records easily. Your health is our priority — accessible anytime, anywhere.
                </p>

                <!-- Search Bar -->
                <div class="mt-8 max-w-lg mx-auto lg:mx-0">
                    <form action="{{ route('doctors') }}" method="GET" class="relative flex items-center bg-white border border-gray-200 rounded-2xl shadow-xl shadow-gray-200/50 p-2">
                        <svg class="absolute left-5 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="q" placeholder="Search doctor name or specialization..." class="flex-1 pl-12 pr-4 py-3 text-sm text-gray-700 bg-transparent focus:outline-none" id="hero-search">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-md shadow-primary-500/25 transition-all hover:shadow-lg hover:shadow-primary-500/30 cursor-pointer">
                            Search
                        </button>
                    </form>
                </div>

                <!-- CTA Buttons -->
                <div class="mt-8 flex flex-wrap justify-center lg:justify-start gap-3">
                    <a href="#" data-open-modal="appointment-modal" class="group inline-flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Book Appointment
                    </a>
                    <a href="#" data-open-modal="special-booking-modal" data-special-type="Emergency" class="group inline-flex items-center gap-2 px-6 py-3.5 bg-red-500 text-white font-semibold rounded-xl shadow-lg shadow-red-500/25 hover:bg-red-600 hover:shadow-xl transition-all hover:-translate-y-0.5 animate-pulse-glow">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Emergency
                    </a>
                    <a href="#" data-open-modal="special-booking-modal" data-special-type="Video Consultation" class="group inline-flex items-center gap-2 px-6 py-3.5 border-2 border-emerald-200 text-emerald-700 font-semibold rounded-xl hover:bg-emerald-50 transition-all hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Online Consultation
                    </a>
                </div>
            </div>

            <!-- Right - Hero Image -->
            <div class="relative hidden lg:flex justify-center animate-fade-in-right">
                <div class="relative">
                    <!-- Decorative circles -->
                    <div class="absolute -top-8 -left-8 w-72 h-72 bg-primary-100 rounded-full opacity-40"></div>
                    <div class="absolute -bottom-6 -right-6 w-56 h-56 bg-emerald-100 rounded-full opacity-40"></div>
                    <!-- Image -->
                    <img src="{{ asset('images/hero-medical.png') }}" alt="Book Appointments with Trusted Doctors" class="relative z-10 w-full max-w-lg rounded-3xl animate-float">
                    <!-- Floating cards -->
                    <div class="absolute top-8 -left-12 z-20 bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-4 animate-fade-in-left animation-delay-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Appointment Confirmed</p>
                                <p class="text-xs text-gray-500">Dr. Sharma • Today 3 PM</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-12 -right-8 z-20 bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-4 animate-fade-in-right animation-delay-500">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">4.9 ★ Rating</p>
                                <p class="text-xs text-gray-500">2,500+ Reviews</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
