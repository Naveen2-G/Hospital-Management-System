<!-- Special Booking Modal (Emergency & Video) -->
<div id="special-booking-modal" class="fixed inset-0 z-100 hidden overflow-y-auto">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm modal-backdrop" data-close-modal="special-booking-modal"></div>

    <!-- Modal Content -->
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up my-auto">
            <!-- Top decorative gradient -->
            <div id="special-modal-gradient" class="h-2 bg-linear-to-r from-red-500 to-rose-600 transition-colors duration-300"></div>

            <!-- Close button -->
            <button class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors z-10 cursor-pointer" data-close-modal="special-booking-modal">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="p-8 sm:p-10">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div id="special-modal-icon-bg" class="w-14 h-14 bg-linear-to-br from-red-500 to-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-red-500/20 transition-colors duration-300">
                        <svg id="special-modal-icon" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900" id="special-modal-title">Priority Booking</h2>
                    <p class="text-gray-500 text-sm mt-1">Please provide your details for immediate assistance</p>
                    <a href="tel:+9118001234567" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-50 text-red-700 text-sm font-semibold hover:bg-red-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Call us: +91 1800-123-4567
                    </a>
                </div>

                <!-- Form -->
                <form id="special-booking-form" class="space-y-4" novalidate>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="sb-name" class="block text-sm font-medium text-gray-700 mb-1.5">Patient Name</label>
                            <input type="text" id="sb-name" placeholder="Full Name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all">
                        </div>
                        <div>
                            <label for="sb-service" class="block text-sm font-medium text-gray-700 mb-1.5">Service Required</label>
                            <select id="sb-service" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all appearance-none cursor-pointer">
                                <option value="Emergency">Emergency</option>
                                <option value="Video Consultation">Video Consultation</option>
                            </select>
                        </div>
                    </div>

                    <div id="sb-doctor-selection" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="sb-department" class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                            <select id="sb-department" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all appearance-none cursor-pointer">
                                <option value="">Select Department</option>
                                @php
                                    $sbDepartments = collect();
                                    if (\Illuminate\Support\Facades\Schema::hasTable('departments')) {
                                        $sbDepartments = \App\Models\Department::query()->orderBy('name')->get();
                                    }
                                @endphp
                                @foreach($sbDepartments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sb-doctor" class="block text-sm font-medium text-gray-700 mb-1.5">Doctor</label>
                            <select id="sb-doctor" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all appearance-none cursor-pointer">
    <option value="">Select Doctor</option>

    @php
        $sbDoctors = collect();

        if (\Illuminate\Support\Facades\Schema::hasTable('doctors')) {
            $sbDoctors = \App\Models\Doctor::with('department')
                ->orderBy('name')
                ->get();
        }
    @endphp

    @foreach($sbDoctors as $doc)
        <option value="{{ $doc->id }}" data-dept="{{ $doc->department_id }}">
            {{ $doc->name }} ({{ $doc->department->name ?? 'General' }})
        </option>
    @endforeach
</select>
                        </div>
                    </div>

                    <div>
                        <label for="sb-whatsapp" class="block text-sm font-medium text-gray-700 mb-1.5">WhatsApp Number <span class="text-xs font-normal text-gray-500">(For instant link/updates)</span></label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            <input type="tel" id="sb-whatsapp" placeholder="+91 98765 43210" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all">
                        </div>
                    </div>

                    <div>
                        <label for="sb-reason" class="block text-sm font-medium text-gray-700 mb-1.5">Brief Description of Issue</label>
                        <textarea id="sb-reason" rows="3" placeholder="Please describe the symptoms or reason for the booking..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all resize-none"></textarea>
                    </div>

                    <button type="submit" id="sb-submit-btn" class="w-full py-3.5 bg-linear-to-r from-red-500 to-rose-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-rose-700 shadow-lg shadow-red-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5 cursor-pointer mt-4">
                        Confirm Booking
                    </button>
                </form>

                <!-- Success State -->
                <div id="sb-success" class="hidden text-center py-6">
                    <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Request Received!</h3>
                    <p class="text-gray-500 mb-6">We have received your request. Our support team will contact you on WhatsApp immediately.</p>
                    <button type="button" class="px-8 py-3.5 bg-linear-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/20 transition-all hover:shadow-xl" data-close-modal="special-booking-modal">
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
