<!-- Forgot Password Modal -->
<div id="forgot-password-modal" class="fixed inset-0 z-[100] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm modal-backdrop" data-close-modal="forgot-password-modal"></div>

    <!-- Modal Content -->
    <div class="relative flex items-center justify-center min-h-screen p-4 overflow-y-auto">
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up max-h-[90vh] overflow-y-auto scrollbar-hidden my-auto">
            <!-- Top decorative gradient -->
            <div class="h-2 bg-gradient-to-r from-amber-400 via-primary-500 to-primary-600"></div>

            <!-- Close button -->
            <button class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors z-10" data-close-modal="forgot-password-modal">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="p-8 sm:p-10">

                <!-- Step 1: Enter Email -->
                <div id="fp-step-email">
                    <div class="text-center mb-8">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-primary-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Forgot Password?</h2>
                        <p class="text-gray-500 text-sm mt-2 leading-relaxed">No worries! Enter the email address linked to your account and we'll send you a verification code.</p>
                    </div>

                    <form id="forgot-password-form" class="space-y-5">
                        <div>
                            <label for="fp-email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                            <div class="relative">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                <input type="email" id="fp-email" placeholder="you@example.com" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-lg shadow-primary-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                            Send Verification Code
                        </button>
                    </form>

                    <p class="text-center text-sm text-gray-500 mt-6">
                        Remember your password?
                        <button class="text-primary-600 font-semibold hover:text-primary-700" data-switch-modal="login-modal" data-close-modal="forgot-password-modal">Back to Login</button>
                    </p>
                </div>

                <!-- Step 2: OTP Verification -->
                <div id="fp-step-otp" class="hidden">
                    <div class="text-center mb-8">
                        <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Verify Your Email</h2>
                        <p class="text-gray-500 text-sm mt-2 leading-relaxed">We've sent a 6-digit code to<br><span id="fp-sent-email" class="font-semibold text-gray-700"></span></p>
                    </div>

                    <form id="fp-otp-form" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3 text-center">Enter Verification Code</label>
                            <div class="flex gap-2 justify-center" id="otp-inputs">
                                <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all otp-input" data-index="0" inputmode="numeric">
                                <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all otp-input" data-index="1" inputmode="numeric">
                                <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all otp-input" data-index="2" inputmode="numeric">
                                <span class="flex items-center text-gray-300 text-xl font-light px-1">-</span>
                                <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all otp-input" data-index="3" inputmode="numeric">
                                <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all otp-input" data-index="4" inputmode="numeric">
                                <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all otp-input" data-index="5" inputmode="numeric">
                            </div>
                        </div>
                        <button type="submit" id="fp-verify-btn" class="w-full py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-lg shadow-primary-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                            Verify Code
                        </button>
                    </form>

                    <div class="text-center mt-5">
                        <p class="text-sm text-gray-500">Didn't receive the code?
                            <button id="fp-resend-btn" class="text-primary-600 font-semibold hover:text-primary-700 disabled:text-gray-400 disabled:cursor-not-allowed" disabled>Resend in <span id="fp-timer">30</span>s</button>
                        </p>
                    </div>
                </div>

                <!-- Step 3: Reset Password -->
                <div id="fp-step-reset" class="hidden">
                    <div class="text-center mb-8">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-primary-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Create New Password</h2>
                        <p class="text-gray-500 text-sm mt-2 leading-relaxed">Your new password must be different from your previously used password.</p>
                    </div>

                    <form id="fp-reset-form" class="space-y-5">
                        <div>
                            <label for="fp-new-password" class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                            <div class="relative">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                <input type="password" id="fp-new-password" placeholder="Min. 8 characters" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                            </div>
                            <div class="mt-2.5 space-y-1.5">
                                <div class="flex gap-1.5">
                                    <div class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300" id="pw-str-1"></div>
                                    <div class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300" id="pw-str-2"></div>
                                    <div class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300" id="pw-str-3"></div>
                                    <div class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300" id="pw-str-4"></div>
                                </div>
                                <p class="text-xs font-medium transition-colors" id="pw-str-label">&nbsp;</p>
                            </div>
                        </div>
                        <div>
                            <label for="fp-confirm-password" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                            <div class="relative">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                <input type="password" id="fp-confirm-password" placeholder="Re-enter your password" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-primary-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-primary-700 shadow-lg shadow-emerald-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                            Reset Password
                        </button>
                    </form>
                </div>

                <!-- Step 4: Success -->
                <div id="fp-step-success" class="hidden text-center py-4">
                    <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Password Reset Successful!</h3>
                    <p class="text-gray-500 mb-6 leading-relaxed">Your password has been changed successfully. You can now sign in with your new password.</p>
                    <button type="button" class="px-8 py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5" data-switch-modal="login-modal" data-close-modal="forgot-password-modal">
                        Back to Login
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
