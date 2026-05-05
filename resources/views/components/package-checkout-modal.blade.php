<!-- Package Checkout Modal -->
<div id="package-checkout-modal" class="fixed inset-0 z-[100] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm modal-backdrop" data-close-modal="package-checkout-modal"></div>

    <!-- Modal Content -->
    <div class="relative flex items-center justify-center min-h-screen p-4 overflow-y-auto">
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-visible animate-fade-in-up my-auto">
            <!-- Top decorative gradient -->
            <div class="h-2 bg-gradient-to-r from-primary-500 via-primary-600 to-emerald-500"></div>

            <!-- Close button -->
            <button class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors z-10 cursor-pointer" data-close-modal="package-checkout-modal">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="p-8 sm:p-10">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Purchase Package</h2>
                    <p class="text-gray-500 text-sm mt-1">Complete your details to proceed to payment</p>
                </div>

                <!-- Package Summary Box -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-500 font-medium">Selected Package</span>
                        <span class="text-xs font-bold px-2 py-1 bg-primary-100 text-primary-700 rounded-lg" id="checkout-pkg-badge">Basic</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-gray-900 font-bold text-lg" id="checkout-pkg-name">Basic Health Check</span>
                        <span class="text-primary-600 font-extrabold text-xl" id="checkout-pkg-price">₹1,999</span>
                    </div>
                </div>

                <!-- Form -->
                <form id="package-checkout-form" class="space-y-4" action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <!-- Hidden inputs for package details -->
                    <input type="hidden" name="package_name" id="hidden-pkg-name" value="">
                    <input type="hidden" name="package_price" id="hidden-pkg-price" value="">

                    <div>
                        <label for="checkout-name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                        <input type="text" name="name" id="checkout-name" placeholder="John Doe" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                    </div>
                    
                    <div>
                        <label for="checkout-email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                        <input type="email" name="email" id="checkout-email" placeholder="you@example.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                    </div>
                    
                    <div>
                        <label for="checkout-phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                        <input type="tel" name="phone" id="checkout-phone" placeholder="+91 98765 43210" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all" required>
                    </div>

                    <button type="submit" class="w-full py-3.5 mt-2 flex justify-center items-center gap-2 bg-gradient-to-r from-gray-900 to-gray-800 text-white font-semibold rounded-xl hover:from-black hover:to-gray-900 shadow-lg shadow-gray-900/20 transition-all hover:shadow-xl hover:-translate-y-0.5 cursor-pointer">
                        <svg class="w-5 h-5 text-white/80" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z"/></svg>
                        Pay with Stripe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
