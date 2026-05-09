<!-- Auth Required Modal -->
<div id="auth-required-modal" class="fixed inset-0 z-[110] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm modal-backdrop" data-close-modal="auth-required-modal"></div>

    <!-- Modal Content -->
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up">
            
            <div class="h-2 bg-gradient-to-r from-primary-500 to-emerald-500"></div>

            <!-- Close button -->
            <button class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors z-10" data-close-modal="auth-required-modal">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="p-8 sm:p-10 text-center">
                <!-- Icon -->
                <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-orange-500/20">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Account Required</h3>
                <p class="text-gray-500 mb-8 leading-relaxed">
                    To confirm your appointment, you need to have an account. Your appointment details will be saved!
                </p>

                <div class="space-y-4">
                    <button type="button" data-close-modal="auth-required-modal" data-switch-modal="register-modal" class="w-full py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-lg shadow-primary-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                        Create Account
                    </button>
                    
                    <button type="button" data-close-modal="auth-required-modal" data-switch-modal="login-modal" class="w-full py-3.5 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all">
                        Already have an account? Login
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
