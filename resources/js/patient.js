document.addEventListener('DOMContentLoaded', () => {
    // (Legacy) Tabs support if present
    const tabsRoot = document.querySelector('[data-tabs]');
    if (tabsRoot) {
        const tabs = Array.from(tabsRoot.querySelectorAll('[data-tab]'));
        const panels = Array.from(document.querySelectorAll('[data-tab-panel]'));

        function activate(tabName) {
            tabs.forEach(t => t.classList.toggle('active', t.getAttribute('data-tab') === tabName));
            panels.forEach(p => p.classList.toggle('hidden', p.getAttribute('data-tab-panel') !== tabName));
        }

        tabs.forEach(t => {
            t.addEventListener('click', () => activate(t.getAttribute('data-tab')));
        });
    }

    // Appointment booking: filter doctors by department
    const bookingForm = document.querySelector('form[data-appointment-booking]');
    if (bookingForm) {
        const aptPanel = document.querySelector('[data-apt-panel]');
        const openBtn = document.querySelector('[data-apt-open]');
        const closeBtns = Array.from(document.querySelectorAll('[data-apt-close]'));

        const setPanelOpen = (open) => {
            if (!aptPanel) return;
            aptPanel.classList.toggle('hidden', !open);
            if (open) {
                const firstInput = aptPanel.querySelector('input, select, textarea, button');
                if (firstInput) firstInput.focus?.();
            }
        };

        if (openBtn) openBtn.addEventListener('click', () => setPanelOpen(true));
        closeBtns.forEach(btn => btn.addEventListener('click', () => setPanelOpen(false)));

        const deptSelect = bookingForm.querySelector('[data-department]');
        const doctorSelect = bookingForm.querySelector('[data-doctor]');
        const doctorOptions = doctorSelect ? Array.from(doctorSelect.querySelectorAll('option[data-dept]')) : [];

        const applyDoctorFilter = () => {
            if (!deptSelect || !doctorSelect) return;
            const deptId = deptSelect.value;

            doctorOptions.forEach(opt => {
                const matches = !deptId || opt.getAttribute('data-dept') === deptId;
                opt.hidden = !matches;
            });

            // If current selection is hidden, reset it
            const selected = doctorSelect.options[doctorSelect.selectedIndex];
            if (selected && selected.hidden) {
                doctorSelect.value = '';
            }
        };

        if (deptSelect) {
            deptSelect.addEventListener('change', applyDoctorFilter);
            applyDoctorFilter();
        }
    }
});

