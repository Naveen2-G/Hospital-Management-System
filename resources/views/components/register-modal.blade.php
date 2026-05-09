<!-- Register Modal -->
<div id="register-modal" class="fixed inset-0 z-[100] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm modal-backdrop" data-close-modal="register-modal"></div>

    <!-- Modal Content -->
    <div class="relative flex items-center justify-center min-h-screen p-4 overflow-y-auto">
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up max-h-[90vh] overflow-y-auto scrollbar-hidden my-auto">
            <!-- Top decorative gradient -->
            <div class="h-2 bg-gradient-to-r from-emerald-500 via-primary-500 to-violet-500"></div>

            <!-- Close button -->
            <button class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors z-10" data-close-modal="register-modal">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="p-8 sm:p-10">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-primary-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
                    <p class="text-gray-500 text-sm mt-1">Join us to manage your healthcare journey</p>
                </div>

                <!-- Form -->
                <form id="register-form" class="space-y-4" method="POST" action="{{ route('register.submit') }}">
                    @csrf
                    <div id="register-error" class="hidden rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700"></div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="reg-first-name" class="block text-sm font-medium text-gray-700 mb-1.5">First Name</label>
                            <input type="text" id="reg-first-name" name="first_name" placeholder="John" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                        </div>
                        <div>
                            <label for="reg-last-name" class="block text-sm font-medium text-gray-700 mb-1.5">Last Name</label>
                            <input type="text" id="reg-last-name" name="last_name" placeholder="Doe" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                        </div>
                    </div>
                    <div>
                        <label for="reg-email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <input type="email" id="reg-email" name="email" placeholder="you@example.com" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                        </div>
                    </div>
                    <div>
                        <label for="reg-phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            <input type="tel" id="reg-phone" name="phone" placeholder="+91 98765 43210" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                        </div>
                    </div>
                    <div>
                        <label for="reg-password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            <input type="password" id="reg-password" name="password" placeholder="Min. 8 characters" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="reg-terms" name="terms" value="1" class="w-4 h-4 mt-0.5 rounded border-gray-300 text-primary-500 focus:ring-primary-500/20" required>
                        <label for="reg-terms" class="text-sm text-gray-600">I agree to the <a href="#" class="text-primary-600 font-medium hover:underline">Terms of Service</a> and <a href="#" class="text-primary-600 font-medium hover:underline">Privacy Policy</a></label>
                    </div>
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-primary-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-primary-700 shadow-lg shadow-emerald-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                        Create Account
                    </button>
                </form>

                <!-- Switch to login -->
                <p class="text-center text-sm text-gray-500 mt-6">
                    Already have an account?
                    <button class="text-primary-600 font-semibold hover:text-primary-700" data-switch-modal="login-modal" data-close-modal="register-modal">Sign In</button>
                </p>
            </div>
        </div>
    </div>
</div>
