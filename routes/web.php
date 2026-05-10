<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/doctors', function () {
    return view('pages.doctors');
})->name('doctors');

Route::get('/appointments', function () {
    return view('pages.appointments');
})->name('appointments');

Route::get('/lab-tests', function () {
    return view('pages.lab-tests');
})->name('lab-tests');

Route::get('/health-packages', function () {
    return view('pages.health-packages');
})->name('health-packages');

// ─── Unified Auth Routes ─────────────────────────────────────
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LabReportController;
use App\Http\Controllers\RegisterController;
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::middleware('auth')->get('/lab-orders/{labOrder}/report', [LabReportController::class, 'show'])->name('lab-orders.report');

// ─── Checkout Routes ──────────────────────────────────────────
use App\Http\Controllers\CheckoutController;
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

// ─── Special Booking (Guest) Route ────────────────────────────
use App\Http\Controllers\SpecialBookingController;
Route::post('/special-booking', [SpecialBookingController::class, 'store'])->name('special-booking.store');

// ─── Service Pages ────────────────────────────────────────────

Route::get('/services/cardiology', function () {
    return view('pages.service', ['service' => [
        'title' => 'Cardiology',
        'subtitle' => 'Expert heart care with advanced diagnostics and treatment',
        'meta' => 'Cardiology department at HMS Hospital — heart disease treatment, cardiac surgery, and preventive cardiology.',
        'badge' => 'Heart Care',
        'color' => 'rose',
        'image' => 'images/cardiology.png',
        'heading' => 'Advanced Cardiac Care You Can Trust',
        'description' => 'Our Cardiology department is equipped with state-of-the-art cardiac catheterization labs, echocardiography suites, and electrophysiology facilities. We specialize in diagnosing and treating the full spectrum of cardiovascular diseases — from common conditions like hypertension to complex interventions like coronary artery bypass grafting.',
        'description2' => 'With a team of board-certified cardiologists, cardiac surgeons, and dedicated nursing staff, we provide personalized treatment plans that combine the latest evidence-based practices with compassionate patient care.',
        'info_cards' => [
            ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => '24/7 Emergency Cardiac Care', 'desc' => 'Round-the-clock cardiac emergency services with immediate intervention capabilities.'],
            ['icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z', 'title' => 'Advanced Diagnostics', 'desc' => 'Cardiac CT, MRI, nuclear imaging, and 3D echocardiography for precise diagnosis.'],
            ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'title' => 'Minimally Invasive Procedures', 'desc' => 'Laparoscopic and catheter-based procedures for faster recovery and less discomfort.'],
        ],
        'treatments' => ['Coronary Artery Disease','Heart Failure Management','Arrhythmia & Pacemakers','Coronary Angioplasty & Stenting','Bypass Surgery (CABG)','Heart Valve Repair & Replacement','Preventive Cardiology','Cardiac Rehabilitation','Hypertension Management'],
        'doctors' => [
            ['name' => 'Dr. Rajesh Sharma', 'qualification' => 'MD, DM Cardiology, FACC', 'exp' => '15+ years', 'image' => "images/doctor-coat-9.svg"],
            ['name' => 'Dr. Anita Desai', 'qualification' => 'MD, DM Interventional Cardiology', 'exp' => '12+ years', 'image' => "images/doctor-coat-10.svg"],
            ['name' => 'Dr. Suresh Menon', 'qualification' => 'MS, MCh Cardiac Surgery', 'exp' => '20+ years', 'image' => "images/doctor-coat-11.svg"],
        ],
    ]]);
})->name('cardiology');

Route::get('/services/dermatology', function () {
    return view('pages.service', ['service' => [
        'title' => 'Dermatology',
        'subtitle' => 'Comprehensive skin, hair, and nail care by expert dermatologists',
        'meta' => 'Dermatology department at HMS Hospital — skin treatments, cosmetic procedures, and hair restoration.',
        'badge' => 'Skin Care',
        'color' => 'amber',
        'image' => 'images/dermatology.png',
        'heading' => 'Expert Skin & Hair Care Solutions',
        'description' => 'The Dermatology department at HMS Hospital provides a complete range of medical, surgical, and cosmetic dermatology services. We treat everything from common skin conditions like acne and eczema to complex autoimmune skin disorders and skin cancers.',
        'description2' => 'Our clinic is equipped with advanced laser systems, phototherapy units, and dermoscopy tools. Whether you need treatment for a chronic skin condition or wish to explore cosmetic enhancement options, our dermatologists provide personalized care plans.',
        'info_cards' => [
            ['icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01', 'title' => 'Advanced Laser Treatments', 'desc' => 'Latest laser technology for pigmentation, scars, hair removal, and skin rejuvenation.'],
            ['icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Cosmetic Procedures', 'desc' => 'Botox, dermal fillers, chemical peels, and PRP therapy for youthful skin.'],
            ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'title' => 'Allergy Testing', 'desc' => 'Comprehensive patch testing and allergy screening for skin sensitivities.'],
        ],
        'treatments' => ['Acne & Acne Scars','Eczema & Psoriasis','Vitiligo Treatment','Hair Loss & PRP Therapy','Laser Hair Removal','Skin Cancer Screening','Anti-Aging Treatments','Fungal Infections','Wart & Mole Removal'],
        'doctors' => [
            ['name' => 'Dr. Priya Patel', 'qualification' => 'MD Dermatology, Fellowship Cosmetic Derm', 'exp' => '10+ years', 'image' => "images/doctor-coat-12.svg"],
            ['name' => 'Dr. Neha Gupta', 'qualification' => 'MD Dermatology, DNB', 'exp' => '8+ years', 'image' => "images/doctor-coat-13.svg"],
            ['name' => 'Dr. Raman Joshi', 'qualification' => 'MD, Laser & Cosmetic Surgery', 'exp' => '14+ years', 'image' => "images/doctor-coat-14.svg"],
        ],
    ]]);
})->name('dermatology');

Route::get('/services/neurology', function () {
    return view('pages.service', ['service' => [
        'title' => 'Neurology',
        'subtitle' => 'Specialized care for brain, spine, and nervous system disorders',
        'meta' => 'Neurology department at HMS Hospital — brain and nerve treatments, stroke care, epilepsy management.',
        'badge' => 'Brain & Spine',
        'color' => 'violet',
        'image' => 'images/neurology.png',
        'heading' => 'Comprehensive Neurological Care',
        'description' => 'Our Neurology department offers expert diagnosis and treatment for a wide range of neurological conditions including stroke, epilepsy, multiple sclerosis, Parkinson\'s disease, and neuropathies. We combine clinical expertise with advanced neurodiagnostic technology.',
        'description2' => 'Our dedicated stroke unit provides rapid assessment and thrombolytic therapy, significantly improving outcomes for stroke patients. The department also runs specialized clinics for headache, movement disorders, and neuromuscular diseases.',
        'info_cards' => [
            ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Acute Stroke Unit', 'desc' => 'Specialized stroke response team with door-to-needle time under 30 minutes.'],
            ['icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z', 'title' => 'Advanced Neuroimaging', 'desc' => 'MRI, CT angiography, EEG, EMG, and nerve conduction studies for accurate diagnosis.'],
            ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Neurorehabilitation', 'desc' => 'Comprehensive rehabilitation programs for stroke and traumatic brain injury recovery.'],
        ],
        'treatments' => ['Stroke Management','Epilepsy & Seizure Control','Parkinson\'s Disease','Multiple Sclerosis','Migraine & Headache Clinic','Peripheral Neuropathy','Brain Tumor Management','Spinal Cord Disorders','Dementia & Alzheimer\'s Care'],
        'doctors' => [
            ['name' => 'Dr. Anil Kumar', 'qualification' => 'MD, DM Neurology, FRCP', 'exp' => '20+ years', 'image' => "images/doctor-coat-15.svg"],
            ['name' => 'Dr. Deepa Iyer', 'qualification' => 'MD, DM Neurology', 'exp' => '12+ years', 'image' => "images/doctor-coat-1.svg"],
            ['name' => 'Dr. Sanjay Tiwari', 'qualification' => 'MCh Neurosurgery', 'exp' => '16+ years', 'image' => "images/doctor-coat-2.svg"],
        ],
    ]]);
})->name('neurology');

Route::get('/services/pediatrics', function () {
    return view('pages.service', ['service' => [
        'title' => 'Pediatrics',
        'subtitle' => 'Gentle and expert healthcare for infants, children, and adolescents',
        'meta' => 'Pediatrics department at HMS Hospital — child healthcare, vaccinations, newborn care, and pediatric emergencies.',
        'badge' => 'Child Care',
        'color' => 'sky',
        'image' => 'images/pediatrics.png',
        'heading' => 'Caring for Your Child\'s Health',
        'description' => 'Our Pediatrics department provides comprehensive healthcare for children from birth through adolescence. With child-friendly facilities, play areas, and a gentle approach, we ensure every visit is a positive experience for both the child and the family.',
        'description2' => 'From routine vaccinations and growth monitoring to managing complex pediatric conditions, our board-certified pediatricians work closely with pediatric specialists to deliver coordinated, family-centered care.',
        'info_cards' => [
            ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Newborn & NICU Care', 'desc' => 'Level III NICU with 24/7 neonatologists for premature and critically ill newborns.'],
            ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Vaccination Programs', 'desc' => 'Complete immunization schedules following national and international guidelines.'],
            ['icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Child-Friendly Environment', 'desc' => 'Play areas, colorful rooms, and trained staff to make hospital visits stress-free.'],
        ],
        'treatments' => ['Newborn Screening','Childhood Vaccinations','Growth & Development Assessment','Pediatric Asthma','Childhood Infections','Nutritional Counseling','Behavioral & Developmental Issues','Pediatric Emergencies','Adolescent Health'],
        'doctors' => [
            ['name' => 'Dr. Sneha Reddy', 'qualification' => 'MD Pediatrics, Fellowship Neonatology', 'exp' => '8+ years', 'image' => "images/doctor-coat-3.svg"],
            ['name' => 'Dr. Vivek Saxena', 'qualification' => 'MD Pediatrics, DCH', 'exp' => '15+ years', 'image' => "images/doctor-coat-4.svg"],
            ['name' => 'Dr. Pooja Menon', 'qualification' => 'MD, Pediatric Pulmonology', 'exp' => '10+ years', 'image' => "images/doctor-coat-5.svg"],
        ],
    ]]);
})->name('pediatrics');

Route::get('/services/emergency', function () {
    return view('pages.service', ['service' => [
        'title' => 'Emergency Care',
        'subtitle' => '24/7 emergency medical services for critical and life-threatening conditions',
        'meta' => 'Emergency Care at HMS Hospital — 24/7 trauma center, ambulance services, and critical care.',
        'badge' => '24/7 Emergency',
        'color' => 'red',
        'image' => 'images/emergency.png',
        'heading' => 'Immediate Care When You Need It Most',
        'description' => 'Our Emergency Department operates 24 hours a day, 7 days a week, 365 days a year. Staffed by board-certified emergency medicine physicians, trauma surgeons, and critical care nurses, we are equipped to handle everything from minor injuries to major trauma and cardiac emergencies.',
        'description2' => 'With an average door-to-doctor time of under 10 minutes, advanced life support ambulances, and a fully equipped trauma bay, HMS Hospital ensures that every emergency patient receives rapid, expert care.',
        'info_cards' => [
            ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Under 10-Minute Response', 'desc' => 'Average door-to-doctor time under 10 minutes with immediate triage and assessment.'],
            ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Advanced Life Support', 'desc' => 'Fully equipped ambulances with ALS capabilities and trained paramedic teams.'],
            ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'title' => 'ICU & Trauma Center', 'desc' => 'Level II trauma center with dedicated ICU beds and round-the-clock specialists.'],
        ],
        'treatments' => ['Trauma & Accident Care','Cardiac Emergencies','Stroke Response','Respiratory Emergencies','Poisoning & Overdose','Burns & Wound Care','Fracture Management','Pediatric Emergencies','Surgical Emergencies'],
        'doctors' => [
            ['name' => 'Dr. Vikram Singh', 'qualification' => 'MD Emergency Medicine, FACEP', 'exp' => '14+ years', 'image' => "images/doctor-coat-6.svg"],
            ['name' => 'Dr. Nisha Kapoor', 'qualification' => 'MS General Surgery, Trauma Fellowship', 'exp' => '12+ years', 'image' => "images/doctor-coat-7.svg"],
            ['name' => 'Dr. Rahul Mehta', 'qualification' => 'MD Critical Care Medicine', 'exp' => '10+ years', 'image' => "images/doctor-coat-8.svg"],
        ],
    ]]);
})->name('emergency');

// ─── Admin Routes ─────────────────────────────────────────────
use App\Http\Controllers\Admin\DashboardController;

// Redirect /admin/login to main site (login modal opens automatically)
Route::get('/admin/login', function () {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (Auth::check() && $user && $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect('/?login=1');
})->name('admin.login');

// Admin logout uses unified controller
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Doctor Protected Routes
Route::prefix('doctor')->middleware(['auth'])->name('doctor.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('dashboard.index');
    // Doctor dashboard sections (single controller, different route names)
    Route::get('/appointments', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('appointments');
    Route::get('/patients', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('patients');
    Route::get('/consultations', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('consultations');
    Route::get('/prescriptions', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('prescriptions');
    Route::get('/labs', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('labs');
    Route::get('/schedule', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('schedule');
    Route::get('/notifications', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('notifications');
    Route::get('/reports', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('reports');
    Route::get('/profile', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('profile');
    Route::post('/change-password', [\App\Http\Controllers\Doctor\ChangePasswordController::class, 'update'])->name('change-password.update');

    Route::post('/appointments/{appointment}/status', [\App\Http\Controllers\Doctor\ActionController::class, 'updateAppointmentStatus'])->name('appointments.status');
    Route::post('/appointments/{appointment}/reschedule', [\App\Http\Controllers\Doctor\ActionController::class, 'rescheduleAppointment'])->name('appointments.reschedule');
    Route::post('/consultations', [\App\Http\Controllers\Doctor\ActionController::class, 'storeConsultation'])->name('consultations.store');
    Route::post('/prescriptions', [\App\Http\Controllers\Doctor\ActionController::class, 'storePrescription'])->name('prescriptions.store');
    Route::get('/prescriptions/{prescription}/print', [\App\Http\Controllers\Doctor\ActionController::class, 'printPrescription'])->name('prescriptions.print');
    Route::get('/form-data', [\App\Http\Controllers\Doctor\ActionController::class, 'formData'])->name('form-data');
    Route::post('/lab-orders', [\App\Http\Controllers\Doctor\ActionController::class, 'storeLabOrder'])->name('lab-orders.store');
});

// Admin Protected Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/search', [\App\Http\Controllers\Admin\SearchController::class, 'index'])->name('search');
    
    // Change Password
    Route::post('/change-password', [\App\Http\Controllers\Admin\ChangePasswordController::class, 'update'])->name('change-password.update');

    // Accounts (registered patients)
    Route::get('/accounts', [\App\Http\Controllers\Admin\AccountController::class, 'index'])->name('accounts.index');

    // Patients
    Route::resource('patients', \App\Http\Controllers\Admin\PatientController::class);

    // Doctors
    Route::resource('doctors', \App\Http\Controllers\Admin\DoctorController::class);

    // Appointments
    Route::resource('appointments', \App\Http\Controllers\Admin\AppointmentController::class);

    // Admissions (OPD/IPD)
    Route::resource('admissions', \App\Http\Controllers\Admin\AdmissionController::class);

    // Rooms
    Route::resource('rooms', \App\Http\Controllers\Admin\RoomController::class);

    // Pharmacy
    Route::resource('pharmacy', \App\Http\Controllers\Admin\PharmacyController::class);

    // Lab
    Route::resource('lab-tests', \App\Http\Controllers\Admin\LabController::class);
    Route::put('lab-orders/{labOrder}', [\App\Http\Controllers\Admin\LabController::class, 'updateOrder'])->name('lab-orders.update');

    // Billing
    Route::resource('billing', \App\Http\Controllers\Admin\BillingController::class);
    Route::get('billing/{invoice}/print', [\App\Http\Controllers\Admin\BillingController::class, 'print'])->name('billing.print');

    // Staff
    Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class);

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');

    // Audit Logs
    Route::get('/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit-logs.index');
});

// Patient Protected Routes
Route::prefix('patient')->middleware(['auth', 'patient'])->name('patient.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Patient\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\Patient\DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/appointments', [\App\Http\Controllers\Patient\AppointmentController::class, 'store'])->name('appointments.store');

    // Change password
    Route::get('/change-password', [\App\Http\Controllers\Patient\ChangePasswordController::class, 'edit'])->name('change-password.edit');
    Route::post('/change-password', [\App\Http\Controllers\Patient\ChangePasswordController::class, 'update'])->name('change-password.update');

    // Invoice payments (Stripe)
    Route::get('/invoices/{invoice}/pay', [\App\Http\Controllers\Patient\InvoicePaymentController::class, 'create'])->name('invoices.payment.create');
    Route::get('/invoices/{invoice}/pay/success', [\App\Http\Controllers\Patient\InvoicePaymentController::class, 'success'])->name('invoices.payment.success');
    Route::get('/invoices/{invoice}/pay/cancel', [\App\Http\Controllers\Patient\InvoicePaymentController::class, 'cancel'])->name('invoices.payment.cancel');

    // Profile
    Route::put('/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'update'])->name('profile.update');
});

