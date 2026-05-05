import './bootstrap';

// ─── Mobile Menu Toggle ────────────────────────────────────────
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
const menuIconOpen = document.getElementById('menu-icon-open');
const menuIconClose = document.getElementById('menu-icon-close');

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuIconOpen.classList.toggle('hidden');
        menuIconClose.classList.toggle('hidden');
    });
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            menuIconOpen.classList.remove('hidden');
            menuIconClose.classList.add('hidden');
        });
    });
}

// ─── Navbar Scroll Effect ──────────────────────────────────────
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar?.classList.toggle('shadow-md', window.scrollY > 50);
});

// ─── Scroll Reveal Animation ──────────────────────────────────
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// ─── Stats Counter Animation ──────────────────────────────────
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const el = entry.target;
            const target = parseInt(el.dataset.count);
            let current = 0;
            const increment = Math.ceil(target / 60);
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) { current = target; clearInterval(timer); }
                el.textContent = current.toLocaleString() + '+';
            }, 25);
            counterObserver.unobserve(el);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('[data-count]').forEach(c => counterObserver.observe(c));

// ─── Testimonials Carousel ────────────────────────────────────
const track = document.getElementById('testimonial-track');
const prevBtn = document.getElementById('testimonial-prev');
const nextBtn = document.getElementById('testimonial-next');
if (track && prevBtn && nextBtn) {
    let position = 0;
    const cardWidth = () => track.children[0]?.offsetWidth || 400;
    const maxScroll = () => track.scrollWidth - track.parentElement.offsetWidth;
    nextBtn.addEventListener('click', () => { position = Math.min(position + cardWidth(), maxScroll()); track.style.transform = `translateX(-${position}px)`; });
    prevBtn.addEventListener('click', () => { position = Math.max(position - cardWidth(), 0); track.style.transform = `translateX(-${position}px)`; });
    let autoScroll = setInterval(() => { position += cardWidth(); if (position > maxScroll()) position = 0; track.style.transform = `translateX(-${position}px)`; }, 4000);
    track.parentElement.addEventListener('mouseenter', () => clearInterval(autoScroll));
    track.parentElement.addEventListener('mouseleave', () => { autoScroll = setInterval(() => { position += cardWidth(); if (position > maxScroll()) position = 0; track.style.transform = `translateX(-${position}px)`; }, 4000); });
}

// ═══════════════════════════════════════════════════════════════
// ─── VALIDATION SYSTEM ────────────────────────────────────────
// ═══════════════════════════════════════════════════════════════

const errorIcon = '<svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';

function showError(input, message) {
    clearError(input);
    input.classList.add('input-error');
    input.classList.remove('input-success');
    // Shake effect
    const wrapper = input.closest('div') || input.parentElement;
    wrapper.classList.add('shake');
    setTimeout(() => wrapper.classList.remove('shake'), 400);
    // Create error message
    const errorEl = document.createElement('div');
    errorEl.className = 'validation-error';
    errorEl.innerHTML = `${errorIcon}<span>${message}</span>`;
    // Insert after the input's parent (handles the relative wrapper for icon inputs)
    const parent = input.parentElement;
    if (parent.classList.contains('relative')) {
        parent.parentElement.appendChild(errorEl);
    } else {
        parent.appendChild(errorEl);
    }
}

function clearError(input) {
    input.classList.remove('input-error', 'shake');
    const parent = input.parentElement;
    const searchArea = parent.classList.contains('relative') ? parent.parentElement : parent;
    searchArea.querySelectorAll('.validation-error').forEach(e => e.remove());
}

function markSuccess(input) {
    clearError(input);
    input.classList.add('input-success');
}

function clearAllErrors(container) {
    container.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
    container.querySelectorAll('.input-success').forEach(el => el.classList.remove('input-success'));
    container.querySelectorAll('.validation-error').forEach(el => el.remove());
    container.querySelectorAll('.shake').forEach(el => el.classList.remove('shake'));
}

// Validation rules
const validators = {
    required: (val) => val.trim() !== '',
    email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
    phone: (val) => /^[\+]?[\d\s\-()]{7,15}$/.test(val.trim()),
    minLength: (val, len) => val.trim().length >= len,
    number: (val) => !isNaN(val) && val.trim() !== '',
    checked: (el) => el.checked,
};

function validateField(input, rules) {
    const val = input.value || '';
    for (const rule of rules) {
        if (rule.type === 'required' && !validators.required(val)) {
            showError(input, rule.msg || 'This field is mandatory');
            return false;
        }
        if (rule.type === 'email' && val.trim() && !validators.email(val)) {
            showError(input, rule.msg || 'Please enter a valid email address');
            return false;
        }
        if (rule.type === 'phone' && val.trim() && !validators.phone(val)) {
            showError(input, rule.msg || 'Please enter a valid phone number');
            return false;
        }
        if (rule.type === 'minLength' && val.trim() && !validators.minLength(val, rule.value)) {
            showError(input, rule.msg || `Minimum ${rule.value} characters required`);
            return false;
        }
        if (rule.type === 'number' && !validators.number(val)) {
            showError(input, rule.msg || 'Please enter a valid number');
            return false;
        }
    }
    markSuccess(input);
    return true;
}

function validateRadioGroup(container, name, errorMsg) {
    const radios = container.querySelectorAll(`input[name="${name}"]`);
    const checked = [...radios].some(r => r.checked);
    if (!checked) {
        // Show error on the radio group container
        const groupDiv = radios[0]?.closest('.flex')?.parentElement;
        if (groupDiv) {
            const existing = groupDiv.querySelector('.validation-error');
            if (!existing) {
                const errorEl = document.createElement('div');
                errorEl.className = 'validation-error';
                errorEl.innerHTML = `${errorIcon}<span>${errorMsg}</span>`;
                groupDiv.appendChild(errorEl);
            }
            // Highlight radio labels
            radios.forEach(r => {
                const label = r.closest('label');
                if (label) { label.style.borderColor = '#f87171'; label.classList.add('shake'); setTimeout(() => label.classList.remove('shake'), 400); }
            });
        }
        return false;
    } else {
        // Clear radio errors
        const groupDiv = radios[0]?.closest('.flex')?.parentElement;
        groupDiv?.querySelectorAll('.validation-error').forEach(e => e.remove());
        radios.forEach(r => { const label = r.closest('label'); if (label) label.style.borderColor = ''; });
        return true;
    }
}

function validateCheckbox(checkbox, errorMsg) {
    if (!checkbox.checked) {
        const wrapper = checkbox.closest('.flex') || checkbox.parentElement;
        const existing = wrapper.querySelector('.validation-error');
        if (!existing) {
            const errorEl = document.createElement('div');
            errorEl.className = 'validation-error';
            errorEl.innerHTML = `${errorIcon}<span>${errorMsg}</span>`;
            wrapper.parentElement.insertBefore(errorEl, wrapper.nextSibling);
        }
        checkbox.classList.add('input-error');
        return false;
    }
    checkbox.classList.remove('input-error');
    const wrapper = checkbox.closest('.flex') || checkbox.parentElement;
    wrapper.parentElement.querySelectorAll('.validation-error').forEach(e => e.remove());
    return true;
}

// Live validation on input (clear error as user types)
function addLiveValidation(input, rules) {
    input.addEventListener('input', () => {
        if (input.classList.contains('input-error')) {
            validateField(input, rules);
        }
    });
    input.addEventListener('blur', () => {
        if (input.value.trim()) validateField(input, rules);
    });
}

// ═══════════════════════════════════════════════════════════════
// ─── MODAL SYSTEM ─────────────────────────────────────────────
// ═══════════════════════════════════════════════════════════════

function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (id === 'appointment-modal') resetAppointmentForm();
    // Clear errors when opening
    clearAllErrors(modal);
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('hidden');
    document.body.style.overflow = '';
    clearAllErrors(modal);
}

document.querySelectorAll('[data-open-modal]').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        openModal(btn.dataset.openModal);

        // Handle department and doctor pre-selection for appointment modal
        if (btn.dataset.openModal === 'appointment-modal') {
            const dept = btn.dataset.department;
            const doc = btn.dataset.doctor;
            const deptSelect = document.getElementById('apt-department');
            const docSelect = document.getElementById('apt-doctor');

            if (dept && deptSelect) {
                for (let i = 0; i < deptSelect.options.length; i++) {
                    if (deptSelect.options[i].text.toLowerCase().includes(dept.toLowerCase())) {
                        deptSelect.selectedIndex = i;
                        break;
                    }
                }
            }
            if (doc && docSelect) {
                for (let i = 0; i < docSelect.options.length; i++) {
                    if (docSelect.options[i].text.toLowerCase().includes(doc.toLowerCase())) {
                        docSelect.selectedIndex = i;
                        break;
                    }
                }
            }
        }

        // Handle package selection for checkout modal
        if (btn.dataset.openModal === 'package-checkout-modal') {
            const pkgName = btn.dataset.pkgName;
            const pkgPrice = btn.dataset.pkgPrice;
            const pkgDisplayPrice = btn.dataset.pkgDisplayPrice;
            const pkgBadge = btn.dataset.pkgBadge;

            if (pkgName) {
                document.getElementById('checkout-pkg-name').textContent = pkgName;
                document.getElementById('hidden-pkg-name').value = pkgName;
            }
            if (pkgDisplayPrice) {
                document.getElementById('checkout-pkg-price').textContent = pkgDisplayPrice;
            }
            if (pkgPrice) {
                document.getElementById('hidden-pkg-price').value = pkgPrice;
            }
            if (pkgBadge) {
                document.getElementById('checkout-pkg-badge').textContent = pkgBadge;
            }
        }

        // Handle special booking type pre-selection
        if (btn.dataset.openModal === 'special-booking-modal') {
            const specialType = btn.dataset.specialType;
            if (specialType) {
                document.getElementById('sb-service').value = specialType;

                // Update UI based on type
                const gradient = document.getElementById('special-modal-gradient');
                const iconBg = document.getElementById('special-modal-icon-bg');
                const title = document.getElementById('special-modal-title');
                const submitBtn = document.getElementById('sb-submit-btn');

                if (specialType === 'Emergency') {
                    gradient.className = 'h-2 bg-gradient-to-r from-red-500 to-rose-600 transition-colors duration-300';
                    iconBg.className = 'w-14 h-14 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-red-500/20 transition-colors duration-300';
                    title.textContent = 'Emergency Booking';
                    submitBtn.className = 'w-full py-3.5 bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-rose-700 shadow-lg shadow-red-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5 cursor-pointer mt-4';
                } else if (specialType === 'Video Consultation') {
                    gradient.className = 'h-2 bg-gradient-to-r from-emerald-500 to-teal-600 transition-colors duration-300';
                    iconBg.className = 'w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/20 transition-colors duration-300';
                    title.textContent = 'Video Consultation';
                    submitBtn.className = 'w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5 cursor-pointer mt-4';
                }
            }
        }

        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            menuIconOpen?.classList.remove('hidden');
            menuIconClose?.classList.add('hidden');
        }
    });
});

document.querySelectorAll('[data-close-modal]').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        closeModal(btn.dataset.closeModal);
        if (btn.dataset.switchModal) {
            setTimeout(() => openModal(btn.dataset.switchModal), 150);
        }
    });
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') ['login-modal', 'register-modal', 'appointment-modal', 'forgot-password-modal'].forEach(closeModal);
});

// ═══════════════════════════════════════════════════════════════
// ─── AUTO-OPEN LOGIN MODAL (from ?login=1 redirect) ──────────
// ═══════════════════════════════════════════════════════════════

(function () {
    const params = new URLSearchParams(window.location.search);
    if (params.get('login') === '1') {
        setTimeout(() => openModal('login-modal'), 300);
        // Clean URL without reload
        const url = new URL(window.location);
        url.searchParams.delete('login');
        window.history.replaceState({}, '', url.pathname + url.search);
    }
})();

// ═══════════════════════════════════════════════════════════════
// ─── LOGIN FORM VALIDATION ────────────────────────────────────
// ═══════════════════════════════════════════════════════════════

const loginForm = document.getElementById('login-form');
if (loginForm) {
    const loginEmail = document.getElementById('login-email');
    const loginPassword = document.getElementById('login-password');
    const loginError = document.getElementById('login-error');

    addLiveValidation(loginEmail, [{ type: 'required', msg: 'Email address is mandatory' }, { type: 'email' }]);
    addLiveValidation(loginPassword, [{ type: 'required', msg: 'Password is mandatory' }, { type: 'minLength', value: 6, msg: 'Password must be at least 6 characters' }]);

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        let valid = true;
        if (!validateField(loginEmail, [{ type: 'required', msg: 'Email address is mandatory' }, { type: 'email' }])) { valid = false; }
        if (!validateField(loginPassword, [{ type: 'required', msg: 'Password is mandatory' }, { type: 'minLength', value: 6, msg: 'Password must be at least 6 characters' }])) { valid = false; }
        if (!valid) return;

        // Hide previous errors
        if (loginError) loginError.classList.add('hidden');

        const btn = loginForm.querySelector('button[type="submit"]');
        const origText = btn.textContent;
        btn.textContent = 'Signing in...';
        btn.disabled = true;

        try {
            const formData = new FormData(loginForm);
            const response = await fetch(loginForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Success — show green state then redirect
                btn.innerHTML = '✓ Signed in successfully!';
                btn.classList.remove('from-primary-500', 'to-primary-600');
                btn.classList.add('from-emerald-500', 'to-emerald-600');
                setTimeout(() => {
                    window.location.href = data.redirect || '/';
                }, 800);
            } else {
                // Show error
                const msg = data.message || (data.errors && data.errors.email && data.errors.email[0]) || 'Invalid credentials.';
                if (loginError) {
                    loginError.textContent = msg;
                    loginError.classList.remove('hidden');
                }
                btn.textContent = origText;
                btn.disabled = false;
            }
        } catch (err) {
            if (loginError) {
                loginError.textContent = 'Network error. Please try again.';
                loginError.classList.remove('hidden');
            }
            btn.textContent = origText;
            btn.disabled = false;
        }
    });
}

// ═══════════════════════════════════════════════════════════════
// ─── REGISTER FORM VALIDATION ─────────────────────────────────
// ═══════════════════════════════════════════════════════════════

const registerForm = document.getElementById('register-form');
if (registerForm) {
    const regFields = {
        firstName: { el: document.getElementById('reg-first-name'), rules: [{ type: 'required', msg: 'First name is mandatory' }] },
        lastName: { el: document.getElementById('reg-last-name'), rules: [{ type: 'required', msg: 'Last name is mandatory' }] },
        email: { el: document.getElementById('reg-email'), rules: [{ type: 'required', msg: 'Email address is mandatory' }, { type: 'email' }] },
        phone: { el: document.getElementById('reg-phone'), rules: [{ type: 'required', msg: 'Phone number is mandatory' }, { type: 'phone' }] },
        password: { el: document.getElementById('reg-password'), rules: [{ type: 'required', msg: 'Password is mandatory' }, { type: 'minLength', value: 8, msg: 'Password must be at least 8 characters' }] },
    };
    const regTerms = document.getElementById('reg-terms');

    Object.values(regFields).forEach(f => { if (f.el) addLiveValidation(f.el, f.rules); });

    registerForm.addEventListener('submit', (e) => {
        e.preventDefault();
        let valid = true;
        Object.values(regFields).forEach(f => { if (f.el && !validateField(f.el, f.rules)) valid = false; });
        if (regTerms && !validateCheckbox(regTerms, 'You must accept the Terms of Service')) valid = false;
        if (!valid) return;

        const btn = registerForm.querySelector('button[type="submit"]');
        const origText = btn.textContent;
        btn.textContent = 'Creating account...';
        btn.disabled = true;
        setTimeout(() => {
            btn.innerHTML = '✓ Account created!';
            btn.classList.remove('from-emerald-500', 'to-primary-600');
            btn.classList.add('from-emerald-500', 'to-emerald-600');
            setTimeout(() => {
                closeModal('register-modal');
                btn.textContent = origText;
                btn.disabled = false;
                btn.classList.remove('from-emerald-500', 'to-emerald-600');
                btn.classList.add('from-emerald-500', 'to-primary-600');
                registerForm.reset();
            }, 1200);
        }, 1000);
    });
}

// ═══════════════════════════════════════════════════════════════
// ─── APPOINTMENT MULTI-STEP FORM VALIDATION ───────────────────
// ═══════════════════════════════════════════════════════════════

const aptSteps = [document.getElementById('apt-step-1'), document.getElementById('apt-step-2'), document.getElementById('apt-step-3')];
const aptSuccess = document.getElementById('apt-success');
const stepIndicators = [document.getElementById('step-indicator-1'), document.getElementById('step-indicator-2'), document.getElementById('step-indicator-3')];

function showAptStep(stepIndex) {
    aptSteps.forEach((s, i) => { if (s) s.classList.toggle('hidden', i !== stepIndex); });
    if (aptSuccess) aptSuccess.classList.add('hidden');
    stepIndicators.forEach((ind, i) => {
        if (!ind) return;
        const circle = ind.querySelector('div');
        const label = ind.querySelector('span');
        if (i <= stepIndex) {
            circle.className = 'w-8 h-8 rounded-full bg-primary-500 text-white text-sm font-bold flex items-center justify-center';
            if (label) label.className = 'text-sm font-medium text-primary-600 hidden sm:inline';
        } else {
            circle.className = 'w-8 h-8 rounded-full bg-gray-200 text-gray-500 text-sm font-bold flex items-center justify-center';
            if (label) label.className = 'text-sm font-medium text-gray-400 hidden sm:inline';
        }
    });
}

function resetAppointmentForm() {
    const form = document.getElementById('appointment-form');
    if (form) { form.reset(); clearAllErrors(form); }
    showAptStep(0);
}

// Set min date
const aptDate = document.getElementById('apt-date');
if (aptDate) { const today = new Date().toISOString().split('T')[0]; aptDate.setAttribute('min', today); aptDate.value = today; }

// Step 1 fields
const step1Fields = {
    name: { el: document.getElementById('apt-name'), rules: [{ type: 'required', msg: 'Full name is mandatory' }] },
    age: { el: document.getElementById('apt-age'), rules: [{ type: 'required', msg: 'Age is mandatory' }, { type: 'number', msg: 'Please enter a valid age' }] },
    email: { el: document.getElementById('apt-email'), rules: [{ type: 'required', msg: 'Email is mandatory' }, { type: 'email' }] },
    phone: { el: document.getElementById('apt-phone'), rules: [{ type: 'required', msg: 'Phone number is mandatory' }, { type: 'phone' }] },
};
Object.values(step1Fields).forEach(f => { if (f.el) addLiveValidation(f.el, f.rules); });

// Step 2 fields
const step2Fields = {
    dept: { el: document.getElementById('apt-department'), rules: [{ type: 'required', msg: 'Please select a department' }] },
    doctor: { el: document.getElementById('apt-doctor'), rules: [{ type: 'required', msg: 'Please select a doctor' }] },
    date: { el: document.getElementById('apt-date'), rules: [{ type: 'required', msg: 'Please select a date' }] },
    time: { el: document.getElementById('apt-time'), rules: [{ type: 'required', msg: 'Please select a time slot' }] },
};
Object.values(step2Fields).forEach(f => { if (f.el) addLiveValidation(f.el, f.rules); });

// Step 1 → Step 2
document.getElementById('apt-next-1')?.addEventListener('click', () => {
    let valid = true;
    Object.values(step1Fields).forEach(f => { if (f.el && !validateField(f.el, f.rules)) valid = false; });
    if (!validateRadioGroup(document.getElementById('apt-step-1'), 'gender', 'Please select your gender')) valid = false;
    if (!valid) return;
    showAptStep(1);
});

// Step 2 ← Back
document.getElementById('apt-back-2')?.addEventListener('click', () => showAptStep(0));

// Step 2 → Step 3
document.getElementById('apt-next-2')?.addEventListener('click', () => {
    let valid = true;
    Object.values(step2Fields).forEach(f => { if (f.el && !validateField(f.el, f.rules)) valid = false; });
    if (!valid) return;

    // Populate summary
    document.getElementById('summary-name').textContent = document.getElementById('apt-name')?.value || '—';
    document.getElementById('summary-email').textContent = document.getElementById('apt-email')?.value || '—';
    document.getElementById('summary-phone').textContent = document.getElementById('apt-phone')?.value || '—';
    document.getElementById('summary-dept').textContent = document.getElementById('apt-department')?.selectedOptions[0]?.text || '—';
    document.getElementById('summary-doctor').textContent = document.getElementById('apt-doctor')?.selectedOptions[0]?.text || '—';
    const dateVal = document.getElementById('apt-date')?.value;
    document.getElementById('summary-date').textContent = dateVal ? new Date(dateVal).toLocaleDateString('en-IN', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' }) : '—';
    document.getElementById('summary-time').textContent = document.getElementById('apt-time')?.selectedOptions[0]?.text || '—';
    showAptStep(2);
});

// Step 3 ← Back
document.getElementById('apt-back-3')?.addEventListener('click', () => showAptStep(1));

// Final submit
const appointmentForm = document.getElementById('appointment-form');
if (appointmentForm) {
    appointmentForm.addEventListener('submit', (e) => {
        e.preventDefault();
        aptSteps.forEach(s => { if (s) s.classList.add('hidden'); });
        if (aptSuccess) aptSuccess.classList.remove('hidden');
        stepIndicators.forEach(ind => {
            if (!ind) return;
            const circle = ind.querySelector('div');
            circle.className = 'w-8 h-8 rounded-full bg-emerald-500 text-white text-sm font-bold flex items-center justify-center';
            circle.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
        });
    });
}

// Special Booking submit
const specialBookingForm = document.getElementById('special-booking-form');
if (specialBookingForm) {
    specialBookingForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const name = document.getElementById('sb-name');
        const phone = document.getElementById('sb-whatsapp');
        const reason = document.getElementById('sb-reason');

        let valid = true;
        if (!name.value.trim()) { valid = false; name.classList.add('input-error'); } else { name.classList.remove('input-error'); }
        if (!phone.value.trim() || !/^[0-9+\s()-]{10,15}$/.test(phone.value.trim())) { valid = false; phone.classList.add('input-error'); } else { phone.classList.remove('input-error'); }
        if (!reason.value.trim()) { valid = false; reason.classList.add('input-error'); } else { reason.classList.remove('input-error'); }

        if (valid) {
            specialBookingForm.classList.add('hidden');
            const successDiv = document.getElementById('sb-success');
            if (successDiv) successDiv.classList.remove('hidden');
        }
    });
}

// ═══════════════════════════════════════════════════════════════
// ─── FORGOT PASSWORD FLOW ─────────────────────────────────────
// ═══════════════════════════════════════════════════════════════

const fpStepEmail = document.getElementById('fp-step-email');
const fpStepOtp = document.getElementById('fp-step-otp');
const fpStepReset = document.getElementById('fp-step-reset');
const fpStepSuccess = document.getElementById('fp-step-success');

function showFpStep(step) {
    [fpStepEmail, fpStepOtp, fpStepReset, fpStepSuccess].forEach(s => { if (s) s.classList.add('hidden'); });
    if (step) step.classList.remove('hidden');
}

function resetForgotPassword() {
    showFpStep(fpStepEmail);
    const fpForm = document.getElementById('forgot-password-form');
    if (fpForm) fpForm.reset();
    document.querySelectorAll('.otp-input').forEach(i => { i.value = ''; i.classList.remove('input-error', 'input-success'); });
    const fpModal = document.getElementById('forgot-password-modal');
    if (fpModal) clearAllErrors(fpModal);
}

// Reset when opening
const origOpen = openModal;
openModal = function (id) {
    origOpen(id);
    if (id === 'forgot-password-modal') resetForgotPassword();
};

// ─── Step 1: Email Submit ─────────────────────────────────────
const fpEmailInput = document.getElementById('fp-email');
if (fpEmailInput) addLiveValidation(fpEmailInput, [{ type: 'required', msg: 'Email address is mandatory' }, { type: 'email' }]);

const forgotPasswordForm = document.getElementById('forgot-password-form');
if (forgotPasswordForm) {
    forgotPasswordForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!validateField(fpEmailInput, [{ type: 'required', msg: 'Email address is mandatory' }, { type: 'email' }])) return;

        const btn = forgotPasswordForm.querySelector('button[type="submit"]');
        const origText = btn.textContent;
        btn.textContent = 'Sending...';
        btn.disabled = true;

        setTimeout(() => {
            btn.textContent = origText;
            btn.disabled = false;
            // Show email in OTP step
            const sentEmailEl = document.getElementById('fp-sent-email');
            if (sentEmailEl) sentEmailEl.textContent = fpEmailInput.value;
            showFpStep(fpStepOtp);
            // Focus first OTP input
            document.querySelector('.otp-input[data-index="0"]')?.focus();
            // Start resend timer
            startResendTimer();
        }, 1200);
    });
}

// ─── Step 2: OTP Input Logic ──────────────────────────────────
const otpInputs = document.querySelectorAll('.otp-input');
otpInputs.forEach(input => {
    // Auto-advance on input
    input.addEventListener('input', (e) => {
        const val = e.target.value;
        // Only allow digits
        e.target.value = val.replace(/[^0-9]/g, '');
        if (e.target.value && e.target.dataset.index < 5) {
            const nextIdx = parseInt(e.target.dataset.index) + 1;
            // Skip the separator span by finding next otp-input
            document.querySelector(`.otp-input[data-index="${nextIdx}"]`)?.focus();
        }
        // Visual feedback
        if (e.target.value) {
            e.target.classList.add('input-success');
            e.target.classList.remove('input-error');
        }
    });

    // Backspace navigation
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && e.target.dataset.index > 0) {
            const prevIdx = parseInt(e.target.dataset.index) - 1;
            const prev = document.querySelector(`.otp-input[data-index="${prevIdx}"]`);
            if (prev) { prev.focus(); prev.value = ''; prev.classList.remove('input-success'); }
        }
    });

    // Paste support
    input.addEventListener('paste', (e) => {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
        paste.split('').slice(0, 6).forEach((char, i) => {
            const inp = document.querySelector(`.otp-input[data-index="${i}"]`);
            if (inp) { inp.value = char; inp.classList.add('input-success'); }
        });
        const lastIdx = Math.min(paste.length, 5);
        document.querySelector(`.otp-input[data-index="${lastIdx}"]`)?.focus();
    });
});

// Resend timer
let resendInterval = null;
function startResendTimer() {
    let seconds = 30;
    const timerEl = document.getElementById('fp-timer');
    const resendBtn = document.getElementById('fp-resend-btn');
    if (!timerEl || !resendBtn) return;
    resendBtn.disabled = true;
    timerEl.textContent = seconds;
    resendBtn.innerHTML = `Resend in <span id="fp-timer">${seconds}</span>s`;
    if (resendInterval) clearInterval(resendInterval);
    resendInterval = setInterval(() => {
        seconds--;
        const t = document.getElementById('fp-timer');
        if (t) t.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(resendInterval);
            resendBtn.disabled = false;
            resendBtn.textContent = 'Resend Code';
        }
    }, 1000);
}

// Resend click
document.getElementById('fp-resend-btn')?.addEventListener('click', () => {
    startResendTimer();
    // Clear OTP inputs
    otpInputs.forEach(i => { i.value = ''; i.classList.remove('input-success', 'input-error'); });
    document.querySelector('.otp-input[data-index="0"]')?.focus();
});

// OTP form submit
const fpOtpForm = document.getElementById('fp-otp-form');
if (fpOtpForm) {
    fpOtpForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const code = [...otpInputs].map(i => i.value).join('');
        if (code.length < 6) {
            // Highlight empty ones
            otpInputs.forEach(i => {
                if (!i.value) {
                    i.classList.add('input-error');
                    i.classList.remove('input-success');
                }
            });
            // Show error below OTP inputs
            const otpContainer = document.getElementById('otp-inputs');
            if (otpContainer && !otpContainer.parentElement.querySelector('.validation-error')) {
                const errEl = document.createElement('div');
                errEl.className = 'validation-error justify-center mt-2';
                errEl.innerHTML = `${errorIcon}<span>Please enter the complete 6-digit code</span>`;
                otpContainer.parentElement.appendChild(errEl);
            }
            return;
        }
        // Clear any OTP errors
        document.getElementById('otp-inputs')?.parentElement.querySelectorAll('.validation-error').forEach(e => e.remove());

        const btn = document.getElementById('fp-verify-btn');
        const origText = btn.textContent;
        btn.textContent = 'Verifying...';
        btn.disabled = true;
        setTimeout(() => {
            btn.textContent = origText;
            btn.disabled = false;
            showFpStep(fpStepReset);
            document.getElementById('fp-new-password')?.focus();
        }, 1000);
    });
}

// ─── Step 3: Password Strength Meter ──────────────────────────
const fpNewPw = document.getElementById('fp-new-password');
const fpConfirmPw = document.getElementById('fp-confirm-password');
const strBars = [document.getElementById('pw-str-1'), document.getElementById('pw-str-2'), document.getElementById('pw-str-3'), document.getElementById('pw-str-4')];
const strLabel = document.getElementById('pw-str-label');

function getPasswordStrength(pw) {
    let score = 0;
    if (pw.length >= 8) score++;
    if (/[a-z]/.test(pw) && /[A-Z]/.test(pw)) score++;
    if (/[0-9]/.test(pw)) score++;
    if (/[^a-zA-Z0-9]/.test(pw)) score++;
    return score;
}

const strengthConfig = [
    { color: 'bg-gray-200', label: '', labelColor: 'text-gray-400' },
    { color: 'bg-red-400', label: 'Weak', labelColor: 'text-red-500' },
    { color: 'bg-amber-400', label: 'Fair', labelColor: 'text-amber-500' },
    { color: 'bg-primary-400', label: 'Good', labelColor: 'text-primary-500' },
    { color: 'bg-emerald-500', label: 'Strong', labelColor: 'text-emerald-600' },
];

if (fpNewPw) {
    fpNewPw.addEventListener('input', () => {
        const val = fpNewPw.value;
        const score = val ? getPasswordStrength(val) : 0;
        const cfg = strengthConfig[score];
        strBars.forEach((bar, i) => {
            if (!bar) return;
            bar.className = `h-1.5 flex-1 rounded-full transition-all duration-300 ${i < score ? cfg.color : 'bg-gray-200'}`;
        });
        if (strLabel) {
            strLabel.textContent = cfg.label;
            strLabel.className = `text-xs font-medium transition-colors ${cfg.labelColor}`;
        }
    });
    addLiveValidation(fpNewPw, [{ type: 'required', msg: 'New password is mandatory' }, { type: 'minLength', value: 8, msg: 'Password must be at least 8 characters' }]);
}

if (fpConfirmPw) {
    addLiveValidation(fpConfirmPw, [{ type: 'required', msg: 'Please confirm your password' }]);
}

// Reset form submit
const fpResetForm = document.getElementById('fp-reset-form');
if (fpResetForm) {
    fpResetForm.addEventListener('submit', (e) => {
        e.preventDefault();
        let valid = true;
        if (!validateField(fpNewPw, [{ type: 'required', msg: 'New password is mandatory' }, { type: 'minLength', value: 8, msg: 'Password must be at least 8 characters' }])) valid = false;
        if (!validateField(fpConfirmPw, [{ type: 'required', msg: 'Please confirm your password' }])) valid = false;

        // Check passwords match
        if (valid && fpNewPw.value !== fpConfirmPw.value) {
            showError(fpConfirmPw, 'Passwords do not match');
            valid = false;
        }

        if (!valid) return;

        const btn = fpResetForm.querySelector('button[type="submit"]');
        const origText = btn.textContent;
        btn.textContent = 'Resetting...';
        btn.disabled = true;
        setTimeout(() => {
            btn.textContent = origText;
            btn.disabled = false;
            showFpStep(fpStepSuccess);
        }, 1200);
    });
}

// ═══════════════════════════════════════════════════════════════
// ─── DOCTORS FILTER & SEARCH ──────────────────────────────────
// ═══════════════════════════════════════════════════════════════
const filterBtns = document.querySelectorAll('.filter-btn');
const doctorCards = document.querySelectorAll('.doctor-card');
const searchInput = document.getElementById('page-doctor-search');

if (doctorCards.length > 0) {
    let currentFilter = 'All';
    let searchQuery = searchInput ? searchInput.value.toLowerCase() : '';

    const applyFilters = () => {
        doctorCards.forEach(card => {
            const name = card.querySelector('h3').textContent.toLowerCase();
            const dept = card.dataset.department;
            const matchesCategory = (currentFilter === 'All' || dept === currentFilter);
            const matchesSearch = name.includes(searchQuery) || dept.toLowerCase().includes(searchQuery);

            if (matchesCategory && matchesSearch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    };

    if (filterBtns.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active state
                filterBtns.forEach(b => {
                    b.classList.remove('bg-primary-500', 'text-white', 'border-primary-500', 'shadow-md', 'active-filter');
                    b.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
                });
                btn.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
                btn.classList.add('bg-primary-500', 'text-white', 'border-primary-500', 'shadow-md', 'active-filter');

                currentFilter = btn.dataset.filter;
                applyFilters();
            });
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.toLowerCase();
            applyFilters();
        });

        // Initial run to apply ?q= URL parameters
        if (searchQuery) {
            applyFilters();
        }
    }
}
