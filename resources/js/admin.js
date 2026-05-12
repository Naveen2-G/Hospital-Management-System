// ─── Admin Dashboard JavaScript ──────────────────────────────
import '../css/admin.css';

// ─── User Dropdown Toggle ────────────────────────────────────
const userBtn = document.getElementById('user-menu-btn');
const userDropdown = document.getElementById('user-dropdown');

if (userBtn && userDropdown) {
    userBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        userDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
        userDropdown.classList.add('hidden');
    });
}

// ─── Notification Dropdown Toggle ────────────────────────────
const notifBtn = document.getElementById('notif-btn');
const notifDropdown = document.getElementById('notif-dropdown');

if (notifBtn && notifDropdown) {
    notifBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        notifDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!notifDropdown.contains(e.target)) {
            notifDropdown.classList.add('hidden');
        }
    });
}

// ─── Mobile Tabs Menu ────────────────────────────────────────
const mobileTabBtn = document.getElementById('mobile-tab-btn');
const mobileTabMenu = document.getElementById('mobile-tab-menu');

if (mobileTabBtn && mobileTabMenu) {
    mobileTabBtn.addEventListener('click', () => {
        mobileTabMenu.classList.toggle('hidden');
    });
}

// ─── Search Bar Functionality ────────────────────────────────
const searchInput = document.getElementById('admin-search');

if (searchInput) {
    // Focus search with Ctrl+K or Cmd+K
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
    });

    // Prevent default form submission if search is empty
    const searchForm = searchInput.closest('form');
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            if (!searchInput.value.trim()) {
                e.preventDefault();
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // ─── Change Password Modal ──────────────────────────────────
    const changePasswordBtn = document.getElementById('change-password-btn');
    const changePasswordModal = document.getElementById('change-password-modal');
    const closePasswordModal = document.getElementById('close-password-modal');
    const cancelPasswordModal = document.getElementById('cancel-password-modal');
    const changePasswordForm = document.getElementById('change-password-form');

    if (changePasswordBtn && changePasswordModal) {
        // Open modal
        changePasswordBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation(); // Prevent dropdown from interfering
            changePasswordModal.classList.remove('hidden');
            changePasswordForm.reset();
            
            // Hide the user dropdown when modal opens
            const userDropdown = document.getElementById('user-dropdown');
            if (userDropdown) userDropdown.classList.add('hidden');
        });

        // Close modal
        const closeModal = () => {
            changePasswordModal.classList.add('hidden');
            changePasswordForm.reset();
            clearErrors();
        };

        if (closePasswordModal) closePasswordModal.addEventListener('click', closeModal);
        if (cancelPasswordModal) cancelPasswordModal.addEventListener('click', closeModal);

        // Close on backdrop click
        changePasswordModal.addEventListener('click', (e) => {
            if (e.target === changePasswordModal) {
                closeModal();
            }
        });

        // Form submission
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                clearErrors();

                const currentPassword = document.getElementById('current_password');
                const newPassword = document.getElementById('new_password');
                const confirmPassword = document.getElementById('confirm_password');

                // Client-side validation
                if (!currentPassword.value) {
                    showError('current_password_error', 'Current password is required');
                    return;
                }

                if (!newPassword.value) {
                    showError('new_password_error', 'New password is required');
                    return;
                }

                if (newPassword.value.length < 8) {
                    showError('new_password_error', 'New password must be at least 8 characters');
                    return;
                }

                if (!/[A-Z]/.test(newPassword.value)) {
                    showError('new_password_error', 'New password must contain uppercase letter');
                    return;
                }

                if (!/[a-z]/.test(newPassword.value)) {
                    showError('new_password_error', 'New password must contain lowercase letter');
                    return;
                }

                if (!/[0-9]/.test(newPassword.value)) {
                    showError('new_password_error', 'New password must contain number');
                    return;
                }

                if (!confirmPassword.value) {
                    showError('confirm_password_error', 'Please confirm your new password');
                    return;
                }

                if (newPassword.value !== confirmPassword.value) {
                    showError('confirm_password_error', 'Passwords do not match');
                    return;
                }

                // Submit form
                try {
                    const route = changePasswordModal.getAttribute('data-route');
                    const response = await fetch(route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            current_password: currentPassword.value,
                            new_password: newPassword.value,
                            confirm_password: confirmPassword.value,
                        }),
                    });

                    const data = await response.json();

                    if (data.success) {
                        if (window.showToast) {
                            window.showToast('Password updated successfully!', 'success');
                        } else {
                            alert('Password updated successfully!');
                        }
                        closeModal();
                    } else {
                        // Handle errors from server
                        if (data.errors) {
                            Object.entries(data.errors).forEach(([field, messages]) => {
                                if (Array.isArray(messages)) {
                                    showError(`${field}_error`, messages[0]);
                                } else {
                                    showError(`${field}_error`, messages);
                                }
                            });
                        } else {
                            if (window.showToast) {
                                window.showToast(data.message || 'Error updating password', 'error');
                            } else {
                                alert(data.message || 'Error updating password');
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    if (window.showToast) {
                        window.showToast('Error updating password. Please try again.', 'error');
                    }
                }
            });
        }
    }
});

function showError(fieldId, message) {
    const errorElement = document.getElementById(fieldId);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        // Highlight the input field
        const fieldName = fieldId.replace('_error', '');
        const input = document.getElementById(fieldName);
        if (input) {
            input.classList.add('border-red-500');
            input.addEventListener('input', () => {
                input.classList.remove('border-red-500');
            }, { once: true });
        }
    }
}

function clearErrors() {
    document.querySelectorAll('[id$="_error"]').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
}

// ─── Toast System ────────────────────────────────────────────
window.showToast = function(message, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(40px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};

// ─── Confirm Delete ──────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-confirm-delete]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
});

// ─── Chart.js Initialization (if charts exist) ──────────────
async function initCharts() {
    const revenueCanvas = document.getElementById('revenue-chart');
    const appointmentCanvas = document.getElementById('appointment-chart');

    if (!revenueCanvas && !appointmentCanvas) return;

    // Dynamically import Chart.js from CDN
    const { Chart, registerables } = await import('https://cdn.jsdelivr.net/npm/chart.js@4.4.9/+esm');
    Chart.register(...registerables);

    // Revenue Line Chart
    if (revenueCanvas) {
        const revenueData = JSON.parse(revenueCanvas.dataset.chart || '[]');
        new Chart(revenueCanvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: revenueData.map(d => d.date),
                datasets: [{
                    label: 'Revenue (₹)',
                    data: revenueData.map(d => d.amount),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.08)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: (ctx) => `₹${ctx.parsed.y.toLocaleString()}`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 12, weight: '500' }, color: '#9ca3af' }
                    },
                    y: {
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            font: { size: 12 }, color: '#9ca3af',
                            callback: (v) => '₹' + (v >= 1000 ? (v/1000) + 'k' : v)
                        }
                    }
                }
            }
        });
    }

    // Appointment Doughnut Chart
    if (appointmentCanvas) {
        const aptData = JSON.parse(appointmentCanvas.dataset.chart || '{}');
        new Chart(appointmentCanvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
                datasets: [{
                    data: [aptData.pending || 0, aptData.confirmed || 0, aptData.completed || 0, aptData.cancelled || 0],
                    backgroundColor: ['#f59e0b', '#2563eb', '#059669', '#ef4444'],
                    borderWidth: 0,
                    spacing: 3,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 16, usePointStyle: true, pointStyleWidth: 8, font: { size: 12, weight: '500' } }
                    }
                }
            }
        });
    }
}

// Init charts on load
document.addEventListener('DOMContentLoaded', initCharts);

// ─── Active Tab Highlighting ─────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.admin-tab').forEach(tab => {
        const href = tab.getAttribute('href');
        if (href && (currentPath === href || (href !== '/admin' && currentPath.startsWith(href)))) {
            tab.classList.add('active');
        } else if (href === '/admin' && currentPath === '/admin') {
            tab.classList.add('active');
        }
    });
});

// ─── Search Shortcut (Ctrl+K) ────────────────────────────────
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('admin-search')?.focus();
    }
});
