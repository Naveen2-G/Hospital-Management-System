<!-- Testimonials Section -->
<section id="testimonials" class="py-16 lg:py-24 bg-gradient-to-br from-slate-50 via-primary-50/20 to-emerald-50/20 relative overflow-hidden">
    <div class="absolute inset-0 bg-diagonal"></div>
    <div class="absolute top-10 right-10 w-64 h-64 bg-amber-50 rounded-full opacity-30 blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 reveal">
            <span class="inline-block px-4 py-1.5 bg-amber-50 text-amber-600 text-sm font-semibold rounded-full mb-4">Testimonials</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">What Our Patients Say</h2>
            <p class="mt-4 text-gray-600 text-lg max-w-2xl mx-auto">Real experiences from patients who trust us with their health.</p>
        </div>
        <div class="relative overflow-hidden">
            <div id="testimonial-track" class="testimonial-track">
                @php
                $reviews = [
                    ['name'=>'Amit Verma','rating'=>5,'text'=>'Exceptional care from Dr. Sharma. The booking was seamless and the staff was incredibly welcoming. Highly recommend this hospital!','initials'=>'AV','color'=>'bg-blue-100 text-blue-600'],
                    ['name'=>'Sunita Devi','rating'=>5,'text'=>'Best healthcare experience. Online appointment system saved me hours. The doctors are very attentive and professional.','initials'=>'SD','color'=>'bg-emerald-100 text-emerald-600'],
                    ['name'=>'Rakesh Gupta','rating'=>4,'text'=>'Very impressed with the lab test facility. Reports were delivered on time and the online access made it very convenient.','initials'=>'RG','color'=>'bg-violet-100 text-violet-600'],
                    ['name'=>'Meena Kumari','rating'=>5,'text'=>'Dr. Priya Patel is amazing! She took time to explain everything clearly. The whole experience was comfortable and professional.','initials'=>'MK','color'=>'bg-amber-100 text-amber-600'],
                    ['name'=>'Vikram Singh','rating'=>5,'text'=>'Emergency services were quick and efficient. The 24/7 availability gave us peace of mind during a critical situation.','initials'=>'VS','color'=>'bg-red-100 text-red-600'],
                    ['name'=>'Deepa Nair','rating'=>4,'text'=>'Smooth online consultation experience. The video quality was great and the doctor was very thorough with the diagnosis.','initials'=>'DN','color'=>'bg-primary-100 text-primary-600'],
                ];
                @endphp
                @foreach($reviews as $review)
                <div class="min-w-[340px] sm:min-w-[400px] p-3 shrink-0">
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm h-full">
                        <div class="flex items-center gap-1 mb-4">
                            @for($i=0;$i<5;$i++)
                            <svg class="w-4 h-4 {{ $i < $review['rating'] ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed mb-5">"{{ $review['text'] }}"</p>
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-50">
                            <div class="w-10 h-10 rounded-full {{ $review['color'] }} flex items-center justify-center text-sm font-bold">{{ $review['initials'] }}</div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $review['name'] }}</p>
                                <p class="text-xs text-gray-500">Verified Patient</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex justify-center gap-3 mt-8">
                <button id="testimonial-prev" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center hover:bg-primary-50 hover:border-primary-300 transition-colors" aria-label="Previous">
                    <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button id="testimonial-next" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center hover:bg-primary-50 hover:border-primary-300 transition-colors" aria-label="Next">
                    <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>
