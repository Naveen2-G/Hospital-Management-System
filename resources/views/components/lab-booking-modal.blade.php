<!-- Lab Booking Modal -->
<div id="labBookingModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" data-close-modal="labBookingModal"></div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full">
            <div class="absolute top-6 right-6 z-10">
                <button data-close-modal="labBookingModal" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-gray-100 rounded-full cursor-pointer">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex flex-col lg:flex-row">
                <!-- Left Side: Summary -->
                <div class="lg:w-1/3 bg-primary-600 p-8 text-white relative">
                    <div class="relative z-10">
                        <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold rounded-full uppercase tracking-wider">Booking Summary</span>
                        <h2 class="text-2xl font-bold mt-4" id="modal_test_name_display">Lab Test</h2>
                        <p class="text-primary-100 mt-2">Accurate diagnostics at your doorstep.</p>
                    </div>

                    <div class="space-y-6 mt-8 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-primary-200">Total Amount</p>
                                <p class="text-xl font-bold" id="modal_test_price_display">₹0</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm">Home Sample Collection Included</p>
                        </div>
                    </div>

                    <div class="mt-12 p-4 bg-white/10 rounded-2xl border border-white/10 relative z-10">
                        <p class="text-xs text-primary-100 italic">"Our phlebotomists follow strict hygiene protocols for safe home collection."</p>
                    </div>
                </div>

                <!-- Right Side: Form -->
                <div class="lg:w-2/3 p-8 lg:p-10 max-h-[85vh] overflow-y-auto">
                    <form action="{{ route('lab-bookings.store') }}" method="POST" id="labBookingForm">
                        @csrf
                        <input type="hidden" name="test_name" id="modal_test_name_input">
                        <input type="hidden" name="test_price" id="modal_test_price_input">

                        <div class="space-y-8">
                            <!-- Section: Patient Details -->
                            <div>
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Patient Details</h3>
                                <div class="grid sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="patient_name" required placeholder="Enter patient's name" 
                                               value="{{ Auth::check() ? Auth::user()->name : '' }}"
                                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                                        <input type="tel" name="phone" required placeholder="Phone number" 
                                               value="{{ Auth::check() ? Auth::user()->phone : '' }}"
                                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                                        <input type="email" name="email" required placeholder="Email address" 
                                               value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gender <span class="text-red-500">*</span></label>
                                            <select name="gender" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Age <span class="text-red-500">*</span></label>
                                            <input type="number" name="age" required placeholder="Age" min="1" max="120"
                                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Address -->
                            <div>
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Collection Address</h3>
                                <div class="grid gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Address <span class="text-red-500">*</span></label>
                                        <input type="text" name="address" required placeholder="House No, Building, Street" 
                                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                    </div>
                                    <div class="grid sm:grid-cols-3 gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">City <span class="text-red-500">*</span></label>
                                            <input type="text" name="city" required placeholder="City" 
                                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">State <span class="text-red-500">*</span></label>
                                            <input type="text" name="state" required placeholder="State" 
                                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pincode <span class="text-red-500">*</span></label>
                                            <input type="text" name="pincode" required placeholder="Pincode" 
                                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Schedule -->
                            <div>
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Preferred Schedule</h3>
                                <div class="grid sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Preferred Date <span class="text-red-500">*</span></label>
                                        <input type="date" name="preferred_date" required min="{{ date('Y-m-d') }}"
                                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Preferred Time Slot <span class="text-red-500">*</span></label>
                                        <select name="preferred_time_slot" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                                            <option value="06:00 AM - 08:00 AM">06:00 AM - 08:00 AM</option>
                                            <option value="08:00 AM - 10:00 AM">08:00 AM - 10:00 AM</option>
                                            <option value="10:00 AM - 12:00 PM">10:00 AM - 12:00 PM</option>
                                            <option value="12:00 PM - 02:00 PM">12:00 PM - 02:00 PM</option>
                                            <option value="02:00 PM - 04:00 PM">02:00 PM - 04:00 PM</option>
                                            <option value="04:00 PM - 06:00 PM">04:00 PM - 06:00 PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Additional Notes (Optional)</label>
                                <textarea name="notes" rows="3" placeholder="Any specific instructions for the phlebotomist?" 
                                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all"></textarea>
                            </div>

                            <!-- Payment Selection -->
                            <div>
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Payment Method</h3>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <label class="relative flex items-center p-4 border border-gray-200 rounded-2xl cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="payment_method" value="online" checked class="w-4 h-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                        <div class="ml-3">
                                            <p class="text-sm font-bold text-gray-900">Pay Online</p>
                                            <p class="text-xs text-gray-500">Fast & Secure via Card/UPI</p>
                                        </div>
                                        <div class="ml-auto">
                                            <svg class="w-6 h-6 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                        </div>
                                    </label>
                                    <label class="relative flex items-center p-4 border border-gray-200 rounded-2xl cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="payment_method" value="home" class="w-4 h-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                        <div class="ml-3">
                                            <p class="text-sm font-bold text-gray-900">Pay at Home</p>
                                            <p class="text-xs text-gray-500">Pay later during collection</p>
                                        </div>
                                        <div class="ml-auto">
                                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary-500/25 transition-all active:scale-[0.98]">
                                Confirm Lab Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
