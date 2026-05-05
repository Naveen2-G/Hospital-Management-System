<!-- Doctors Section -->
<section id="doctors" class="py-16 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-cross-pattern"></div>
    <div class="absolute top-20 left-0 w-72 h-72 bg-emerald-50 rounded-full opacity-25 blur-3xl"></div>
    <div class="absolute bottom-20 right-0 w-80 h-80 bg-primary-50 rounded-full opacity-25 blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-14 reveal">
            <span class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-600 text-sm font-semibold rounded-full mb-4">Our Specialists</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">Meet Our Top Doctors</h2>
            <p class="mt-4 text-gray-600 text-lg max-w-2xl mx-auto">Experienced healthcare professionals committed to providing the best care for you and your family.</p>
        </div>

        <!-- Doctors Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Doctor 1 -->
            <div class="reveal group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/doctor-male-1.png') }}" alt="Dr. Rajesh Sharma, Cardiologist" class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-emerald-600 shadow-sm">
                        Available
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-lg">Dr. Rajesh Sharma</h3>
                    <p class="text-primary-600 text-sm font-medium mt-1">Cardiology</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">15+ years exp.</span>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm font-semibold text-gray-700">4.9</span>
                        </div>
                    </div>
                    <button data-open-modal="appointment-modal" data-department="Cardiology" data-doctor="Dr. Rajesh Sharma" class="w-full mt-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-md shadow-primary-500/20 transition-all hover:shadow-lg">
                        Book Now
                    </button>
                </div>
            </div>

            <!-- Doctor 2 -->
            <div class="reveal group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/doctor-female-1.png') }}" alt="Dr. Priya Patel, Dermatologist" class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-emerald-600 shadow-sm">
                        Available
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-lg">Dr. Priya Patel</h3>
                    <p class="text-primary-600 text-sm font-medium mt-1">Dermatology</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">10+ years exp.</span>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm font-semibold text-gray-700">4.8</span>
                        </div>
                    </div>
                    <button data-open-modal="appointment-modal" data-department="Dermatology" data-doctor="Dr. Priya Patel" class="w-full mt-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-md shadow-primary-500/20 transition-all hover:shadow-lg">
                        Book Now
                    </button>
                </div>
            </div>

            <!-- Doctor 3 -->
            <div class="reveal group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/doctor-male-2.png') }}" alt="Dr. Anil Kumar, Neurologist" class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-emerald-600 shadow-sm">
                        Available
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-lg">Dr. Anil Kumar</h3>
                    <p class="text-primary-600 text-sm font-medium mt-1">Neurology</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">20+ years exp.</span>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm font-semibold text-gray-700">4.9</span>
                        </div>
                    </div>
                    <button data-open-modal="appointment-modal" data-department="Neurology" data-doctor="Dr. Anil Kumar" class="w-full mt-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-md shadow-primary-500/20 transition-all hover:shadow-lg">
                        Book Now
                    </button>
                </div>
            </div>

            <!-- Doctor 4 -->
            <div class="reveal group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/doctor-female-2.png') }}" alt="Dr. Sneha Reddy, Pediatrician" class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-emerald-600 shadow-sm">
                        Available
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-lg">Dr. Sneha Reddy</h3>
                    <p class="text-primary-600 text-sm font-medium mt-1">Pediatrics</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">8+ years exp.</span>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm font-semibold text-gray-700">4.7</span>
                        </div>
                    </div>
                    <button data-open-modal="appointment-modal" data-department="Pediatrics" data-doctor="Dr. Sneha Reddy" class="w-full mt-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-md shadow-primary-500/20 transition-all hover:shadow-lg">
                        Book Now
                    </button>
                </div>
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-10 reveal">
            <a href="{{ route('doctors') }}" class="inline-flex items-center gap-2 px-8 py-3.5 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-all">
                View All Doctors
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
