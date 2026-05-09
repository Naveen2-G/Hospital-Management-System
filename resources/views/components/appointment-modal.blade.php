<!-- Book Appointment Modal -->
<div id="appointment-modal" class="fixed inset-0 z-[100] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm modal-backdrop" data-close-modal="appointment-modal"></div>

    <!-- Modal Content -->
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up max-h-[90vh] overflow-y-auto scrollbar-hidden">
            
            <div class="h-2 bg-gradient-to-r from-primary-500 to-emerald-500"></div>

            <!-- Close button -->
            <button class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors z-10" data-close-modal="appointment-modal">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="p-8 sm:p-10">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Book an Appointment</h2>
                    <p class="text-gray-500 text-sm mt-1">Fill in the details below to schedule your visit</p>
                </div>

                <!-- Progress Steps -->
                <div class="flex items-center justify-center gap-2 mb-8">
                    <div class="flex items-center gap-2" id="step-indicator-1">
                        <div class="w-8 h-8 rounded-full bg-primary-500 text-white text-sm font-bold flex items-center justify-center">1</div>
                        <span class="text-sm font-medium text-primary-600 hidden sm:inline">Patient Info</span>
                    </div>
                    <div class="w-8 h-px bg-gray-300 sm:w-12"></div>
                    <div class="flex items-center gap-2" id="step-indicator-2">
                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 text-sm font-bold flex items-center justify-center">2</div>
                        <span class="text-sm font-medium text-gray-400 hidden sm:inline">Doctor & Date</span>
                    </div>
                    <div class="w-8 h-px bg-gray-300 sm:w-12"></div>
                    <div class="flex items-center gap-2" id="step-indicator-3">
                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 text-sm font-bold flex items-center justify-center">3</div>
                        <span class="text-sm font-medium text-gray-400 hidden sm:inline">Confirm</span>
                    </div>
                </div>

                <!-- Form -->
                <form id="appointment-form" action="{{ route('patient.appointments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="apt-type" name="appointment_type" value="regular">
                    <!-- Step 1: Patient Info -->
                    <div id="apt-step-1" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="apt-name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    <input type="text" id="apt-name" placeholder="Enter your full name" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                                </div>
                            </div>
                            <div>
                                <label for="apt-age" class="block text-sm font-medium text-gray-700 mb-1.5">Age</label>
                                <input type="number" id="apt-age" placeholder="25" min="1" max="120" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="apt-email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    <input type="email" id="apt-email" placeholder="you@example.com" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                                </div>
                            </div>
                            <div>
                                <label for="apt-phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                    <input type="tel" id="apt-phone" placeholder="+91 98765 43210" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Gender</label>
                            <div class="flex gap-3">
                                <label class="flex-1 flex items-center justify-center gap-2 py-3 border border-gray-200 rounded-xl cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50 has-[:checked]:text-primary-700">
                                    <input type="radio" name="gender" value="male" class="sr-only" required>
                                    <span class="text-sm font-medium">Male</span>
                                </label>
                                <label class="flex-1 flex items-center justify-center gap-2 py-3 border border-gray-200 rounded-xl cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50 has-[:checked]:text-primary-700">
                                    <input type="radio" name="gender" value="female" class="sr-only">
                                    <span class="text-sm font-medium">Female</span>
                                </label>
                                <label class="flex-1 flex items-center justify-center gap-2 py-3 border border-gray-200 rounded-xl cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50 has-[:checked]:text-primary-700">
                                    <input type="radio" name="gender" value="other" class="sr-only">
                                    <span class="text-sm font-medium">Other</span>
                                </label>
                            </div>
                        </div>
                        <button type="button" id="apt-next-1" class="w-full py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-lg shadow-primary-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                            Continue →
                        </button>
                    </div>

                    <!-- Step 2: Doctor & Date -->
                    <div id="apt-step-2" class="space-y-4 hidden">
                        <div>
                            <label for="apt-department" class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                            <select id="apt-department" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all appearance-none cursor-pointer" required>
                                <option value="">Select Department</option>
                                <option value="cardiology">Cardiology</option>
                                <option value="dermatology">Dermatology</option>
                                <option value="neurology">Neurology</option>
                                <option value="pediatrics">Pediatrics</option>
                                <option value="orthopedics">Orthopedics</option>
                                <option value="general">General Medicine</option>
                                <option value="ent">ENT</option>
                                <option value="gynecology">Gynecology</option>
                                <option value="emergency">Emergency</option>
                            </select>
                        </div>
                        <div>
                            <label for="apt-doctor" class="block text-sm font-medium text-gray-700 mb-1.5">Preferred Doctor</label>
                            <select id="apt-doctor" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all appearance-none cursor-pointer" required>
                                <option value="">Select Doctor</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="apt-date" class="block text-sm font-medium text-gray-700 mb-1.5">Preferred Date</label>
                                <input type="date" id="apt-date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                            </div>
                            <div>
                                <label for="apt-time" class="block text-sm font-medium text-gray-700 mb-1.5">Preferred Time</label>
                                <select id="apt-time" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all appearance-none cursor-pointer" required>
                                    <option value="">Select Time Slot</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="09:30">09:30 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="10:30">10:30 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="11:30">11:30 AM</option>
                                    <option value="14:00">02:00 PM</option>
                                    <option value="14:30">02:30 PM</option>
                                    <option value="15:00">03:00 PM</option>
                                    <option value="15:30">03:30 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="apt-reason" class="block text-sm font-medium text-gray-700 mb-1.5">Reason for Visit</label>
                            <textarea id="apt-reason" rows="3" placeholder="Briefly describe your symptoms or reason for the appointment..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all resize-none"></textarea>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" id="apt-back-2" class="flex-1 py-3.5 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                                ← Back
                            </button>
                            <button type="button" id="apt-next-2" class="flex-1 py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-lg shadow-primary-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                                Continue →
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Confirmation -->
                    <div id="apt-step-3" class="hidden">
                        <div class="bg-gradient-to-br from-primary-50 to-emerald-50 rounded-2xl p-6 mb-6 border border-primary-100">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Appointment Summary
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between"><span class="text-gray-500">Patient</span><span class="font-medium text-gray-900" id="summary-name">—</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Email</span><span class="font-medium text-gray-900" id="summary-email">—</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Phone</span><span class="font-medium text-gray-900" id="summary-phone">—</span></div>
                                <div class="h-px bg-primary-100"></div>
                                <div class="flex justify-between"><span class="text-gray-500">Department</span><span class="font-medium text-gray-900" id="summary-dept">—</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Doctor</span><span class="font-medium text-gray-900" id="summary-doctor">—</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Date</span><span class="font-medium text-gray-900" id="summary-date">—</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Time</span><span class="font-medium text-gray-900" id="summary-time">—</span></div>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" id="apt-back-3" class="flex-1 py-3.5 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                                ← Back
                            </button>
                            <button type="submit" class="flex-1 py-3.5 bg-gradient-to-r from-emerald-500 to-primary-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-primary-700 shadow-lg shadow-emerald-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                                ✓ Confirm Appointment
                            </button>
                        </div>
                    </div>

                    <!-- Success State -->
                    <div id="apt-success" class="hidden text-center py-8">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-5">
                            <svg class="w-10 h-10 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Appointment Booked!</h3>
                        <p class="text-gray-500 mb-6">Your appointment has been successfully scheduled. You will receive a confirmation email shortly.</p>
                        <button type="button" class="px-8 py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/20 transition-all hover:shadow-xl" data-close-modal="appointment-modal">
                            Done
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
