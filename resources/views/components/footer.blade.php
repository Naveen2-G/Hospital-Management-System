<!-- Footer -->
<footer id="footer" class="bg-gray-900 text-gray-300 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-gray-800">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-emerald-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <div>
                        <span class="text-lg font-bold text-white">HMS</span>
                        <span class="text-xs text-gray-500 block -mt-1">Hospital Management</span>
                    </div>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed mb-5">Providing quality healthcare services with modern technology and compassionate care since 2010.</p>
                <div class="flex gap-3">
                    @foreach(['M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z','M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z','M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'] as $path)
                    <a href="#" class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary-600 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                    </a>
                    @endforeach
                </div>
            </div>
            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-5">Quick Links</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-primary-400 transition-colors">About Us</a></li>
                    <li><a href="{{ route('doctors') }}" class="hover:text-primary-400 transition-colors">Our Doctors</a></li>
                    <li><a href="{{ route('appointments') }}" class="hover:text-primary-400 transition-colors">Appointments</a></li>
                    <li><a href="{{ route('lab-tests') }}" class="hover:text-primary-400 transition-colors">Lab Tests</a></li>
                    <li><a href="{{ route('health-packages') }}" class="hover:text-primary-400 transition-colors">Health Packages</a></li>
                </ul>
            </div>
            <!-- Services -->
            <div>
                <h4 class="text-white font-semibold mb-5">Services</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('cardiology') }}" class="hover:text-primary-400 transition-colors">Cardiology</a></li>
                    <li><a href="{{ route('dermatology') }}" class="hover:text-primary-400 transition-colors">Dermatology</a></li>
                    <li><a href="{{ route('neurology') }}" class="hover:text-primary-400 transition-colors">Neurology</a></li>
                    <li><a href="{{ route('pediatrics') }}" class="hover:text-primary-400 transition-colors">Pediatrics</a></li>
                    <li><a href="{{ route('emergency') }}" class="hover:text-primary-400 transition-colors">Emergency Care</a></li>
                </ul>
            </div>
            <!-- Contact -->
            <div>
                <h4 class="text-white font-semibold mb-5">Contact Us</h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        123 Medical Avenue, Healthcare District, New Delhi 110001
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-primary-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        +91 1800-123-4567
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-primary-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        info@hms-hospital.com
                    </li>
                </ul>
            </div>
        </div>
        <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Hospital Management System. All rights reserved.</p>
            <div class="flex gap-6 text-sm">
                <a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Privacy Policy</a>
                <a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
