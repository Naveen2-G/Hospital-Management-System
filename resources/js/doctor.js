// import "../css/admin.css";
const appointmentSearch = document.getElementById("appointment-search");
const appointmentStatusFilter = document.getElementById(
    "appointment-status-filter",
);
const appointmentRows = Array.from(
    document.querySelectorAll("[data-appointment-row]"),
);
const appointmentEmptyState = document.getElementById(
    "appointment-filter-empty",
);

const prescriptionItems = document.getElementById("prescription-items");
const addPrescriptionItemButton = document.getElementById(
    "add-prescription-item",
);
const prescriptionItemTemplate = document.getElementById(
    "prescription-item-template",
);

const patientDrawer = document.getElementById("patient-drawer");
const patientDrawerOverlay = document.getElementById("patient-drawer-overlay");
const closePatientDrawerButton = document.getElementById(
    "close-patient-drawer",
);
const pageLoader = document.getElementById("doctor-page-loader");
const appShell = document.getElementById("doctor-app-shell");
const profileToggleButton = document.querySelector(
    "[data-doctor-profile-toggle]",
);
const profileMenu = document.querySelector("[data-doctor-profile-menu]");
const passwordModal = document.getElementById("doctor-password-modal");
const profileModal = document.getElementById("doctor-profile-modal");
const profileOpenButtons = Array.from(
    document.querySelectorAll("[data-doctor-profile-open]"),
);
const profileCloseButtons = Array.from(
    document.querySelectorAll("[data-doctor-profile-close]"),
);
const passwordOpenButtons = Array.from(
    document.querySelectorAll("[data-doctor-password-open]"),
);
const passwordCloseButtons = Array.from(
    document.querySelectorAll("[data-doctor-password-close]"),
);

const patientDrawerFields = {
    name: document.getElementById("patient-drawer-name"),
    phone: document.getElementById("patient-drawer-phone"),
    email: document.getElementById("patient-drawer-email"),
    gender: document.getElementById("patient-drawer-gender"),
    bloodGroup: document.getElementById("patient-drawer-blood-group"),
    dob: document.getElementById("patient-drawer-dob"),
    address: document.getElementById("patient-drawer-address"),
    emergency: document.getElementById("patient-drawer-emergency"),
    visits: document.getElementById("patient-drawer-visits"),
    history: document.getElementById("patient-drawer-history"),
};

function showPageLoader() {
    document.body.classList.add("doctor-loading");
}

function hidePageLoader() {
    document.body.classList.remove("doctor-loading");
}

function filterAppointments() {
    if (
        !appointmentSearch ||
        !appointmentStatusFilter ||
        appointmentRows.length === 0
    ) {
        return;
    }

    const searchValue = appointmentSearch.value.trim().toLowerCase();
    const statusValue = appointmentStatusFilter.value;
    let visibleCount = 0;

    appointmentRows.forEach((row) => {
        const rowStatus = (row.dataset.status || "").toLowerCase();
        const rowSearch = (row.dataset.search || "").toLowerCase();
        const matchesSearch = !searchValue || rowSearch.includes(searchValue);
        const matchesStatus =
            statusValue === "all" || rowStatus === statusValue;
        const isVisible = matchesSearch && matchesStatus;

        row.classList.toggle("hidden", !isVisible);
        if (isVisible) {
            visibleCount += 1;
        }
    });

    if (appointmentEmptyState) {
        appointmentEmptyState.classList.toggle("hidden", visibleCount !== 0);
    }
}

function closePatientDrawer() {
    if (!patientDrawer || !patientDrawerOverlay) {
        return;
    }

    patientDrawer.classList.add("opacity-0", "scale-95", "pointer-events-none");
    patientDrawerOverlay.classList.add("hidden");
}

function closeDoctorProfileMenu() {
    if (!profileMenu) {
        return;
    }

    profileMenu.classList.add("hidden");
}

function openDoctorPasswordModal() {
    if (!passwordModal) {
        return;
    }

    passwordModal.classList.remove("hidden");
    closeDoctorProfileMenu();
}

function closeDoctorPasswordModal() {
    if (!passwordModal) {
        return;
    }

    passwordModal.classList.add("hidden");
}

function openDoctorProfileModal() {
    if (!profileModal) {
        return;
    }

    profileModal.classList.remove("hidden");
    closeDoctorProfileMenu();
}

function closeDoctorProfileModal() {
    if (!profileModal) {
        return;
    }

    profileModal.classList.add("hidden");
}

function renderPatientTimeline(history, timeline) {
    if (!patientDrawerFields.history) {
        return;
    }

    const source =
        Array.isArray(timeline) && timeline.length ? timeline : history;
    patientDrawerFields.history.innerHTML = "";

    if (!Array.isArray(source) || source.length === 0) {
        patientDrawerFields.history.innerHTML =
            '<p class="text-sm text-slate-500">No recent timeline available for this patient.</p>';
        return;
    }

    source.forEach((item, idx) => {
        const entry = document.createElement("div");
        entry.className =
            "history-entry rounded-2xl border border-slate-200 bg-white p-4";

        const titleWrap = document.createElement("div");
        titleWrap.className = "flex items-center justify-between gap-3";

        const left = document.createElement("div");

        const heading = document.createElement("p");
        heading.className = "font-semibold text-slate-900";
        heading.textContent = `${item.display_date || item.date || "—"} · ${item.title || item.department || "Entry"}`;

        const meta = document.createElement("p");
        meta.className = "text-sm text-slate-500";
        meta.textContent = `${item.time || "—"} · ${item.type || item.status || "info"}`;

        const note = document.createElement("p");
        note.className = "mt-3 text-sm text-slate-600";
        note.textContent = item.notes || "No additional notes.";

        left.append(heading, meta);
        titleWrap.append(left);
        entry.append(titleWrap, note);

        patientDrawerFields.history.appendChild(entry);

        // Stagger reveal
        setTimeout(() => entry.classList.add("visible"), 60 * idx);
    });
}

function openPatientDrawerFromButton(button) {
    if (!patientDrawer || !patientDrawerOverlay) {
        return;
    }

    let history = [];
    let timeline = [];

    if (button.dataset.patientHistory) {
        try {
            history = JSON.parse(atob(button.dataset.patientHistory));
        } catch (error) {
            history = [];
        }
    }

    if (button.dataset.patientTimeline) {
        try {
            timeline = JSON.parse(atob(button.dataset.patientTimeline));
        } catch (error) {
            timeline = [];
        }
    }

    if (patientDrawerFields.name)
        patientDrawerFields.name.textContent =
            button.dataset.patientName || "Patient profile";
    if (patientDrawerFields.phone)
        patientDrawerFields.phone.textContent =
            button.dataset.patientPhone || "—";
    if (patientDrawerFields.email)
        patientDrawerFields.email.textContent =
            button.dataset.patientEmail || "—";
    if (patientDrawerFields.gender)
        patientDrawerFields.gender.textContent =
            button.dataset.patientGender || "—";
    if (patientDrawerFields.bloodGroup)
        patientDrawerFields.bloodGroup.textContent =
            button.dataset.patientBloodGroup || "—";
    if (patientDrawerFields.dob)
        patientDrawerFields.dob.textContent = button.dataset.patientDob || "—";
    if (patientDrawerFields.address)
        patientDrawerFields.address.textContent =
            button.dataset.patientAddress || "—";
    if (patientDrawerFields.emergency)
        patientDrawerFields.emergency.textContent =
            button.dataset.patientEmergency || "—";
    if (patientDrawerFields.visits)
        patientDrawerFields.visits.textContent = `${button.dataset.patientVisits || 0} visits`;

    renderPatientTimeline(history, timeline);

    patientDrawer.classList.remove(
        "opacity-0",
        "scale-95",
        "pointer-events-none",
    );
    patientDrawerOverlay.classList.remove("hidden");
}

function addPrescriptionItem() {
    if (!prescriptionItems || !prescriptionItemTemplate) {
        return;
    }

    const index =
        prescriptionItems.querySelectorAll(".prescription-item").length + 1;
    const wrapper = document.createElement("div");
    wrapper.innerHTML = prescriptionItemTemplate.innerHTML
        .replaceAll("__INDEX__", String(index))
        .trim();
    const item = wrapper.firstElementChild;

    if (item) {
        prescriptionItems.appendChild(item);
        updatePrescriptionItemTitles();
    }
}

function updatePrescriptionItemTitles() {
    if (!prescriptionItems) {
        return;
    }

    prescriptionItems
        .querySelectorAll(".prescription-item")
        .forEach((item, index) => {
            const title = item.querySelector("p");
            if (title) {
                title.textContent = `Medicine #${index + 1}`;
            }
        });
}

if (appointmentSearch) {
    appointmentSearch.addEventListener("input", filterAppointments);
}

if (appointmentStatusFilter) {
    appointmentStatusFilter.addEventListener("change", filterAppointments);
}

if (addPrescriptionItemButton) {
    addPrescriptionItemButton.addEventListener("click", addPrescriptionItem);
}

if (prescriptionItems) {
    prescriptionItems.addEventListener("click", (event) => {
        const removeButton = event.target.closest(".remove-prescription-item");
        const upButton = event.target.closest(".move-up-item");
        const downButton = event.target.closest(".move-down-item");
        const editButton = event.target.closest(".edit-prescription-item");

        if (removeButton) {
            const item = removeButton.closest(".prescription-item");
            if (!item) {
                return;
            }

            const items =
                prescriptionItems.querySelectorAll(".prescription-item");
            if (items.length > 1) {
                item.remove();
                updatePrescriptionItemTitles();
                return;
            }

            item.querySelectorAll("input, select, textarea").forEach(
                (field) => {
                    field.value = "";
                },
            );
        }

        if (upButton) {
            const item = upButton.closest(".prescription-item");
            if (item && item.previousElementSibling) {
                prescriptionItems.insertBefore(
                    item,
                    item.previousElementSibling,
                );
                updatePrescriptionItemTitles();
            }
        }

        if (downButton) {
            const item = downButton.closest(".prescription-item");
            if (item && item.nextElementSibling) {
                prescriptionItems.insertBefore(item.nextElementSibling, item);
                updatePrescriptionItemTitles();
            }
        }

        if (editButton) {
            const item = editButton.closest(".prescription-item");
            if (!item) {
                return;
            }

            const firstField = item.querySelector("select, input, textarea");
            if (firstField) {
                firstField.focus();
            }
        }
    });
}

document.querySelectorAll(".open-patient-drawer").forEach((button) => {
    button.addEventListener("click", () => openPatientDrawerFromButton(button));
});

document.addEventListener(
    "click",
    (event) => {
        const anchor = event.target.closest("a");

        if (!anchor || !pageLoader) {
            return;
        }

        if (
            event.defaultPrevented ||
            event.button !== 0 ||
            event.metaKey ||
            event.ctrlKey ||
            event.shiftKey ||
            event.altKey
        ) {
            return;
        }

        if (anchor.target === "_blank" || anchor.hasAttribute("download")) {
            return;
        }

        const href = anchor.getAttribute("href");
        if (
            !href ||
            href.startsWith("#") ||
            href.startsWith("mailto:") ||
            href.startsWith("tel:")
        ) {
            return;
        }

        let targetUrl;

        try {
            targetUrl = new URL(anchor.href, window.location.href);
        } catch (error) {
            return;
        }

        if (targetUrl.origin !== window.location.origin) {
            return;
        }

        const currentUrl = new URL(window.location.href);
        const samePage =
            targetUrl.pathname === currentUrl.pathname &&
            targetUrl.search === currentUrl.search &&
            targetUrl.hash === currentUrl.hash;

        if (samePage) {
            return;
        }

        event.preventDefault();
        showPageLoader();

        window.requestAnimationFrame(() => {
            window.location.assign(targetUrl.toString());
        });
    },
    true,
);

document.addEventListener(
    "submit",
    (event) => {
        if (!pageLoader) {
            return;
        }

        showPageLoader();
    },
    true,
);

if (closePatientDrawerButton) {
    closePatientDrawerButton.addEventListener("click", closePatientDrawer);
}

if (profileToggleButton && profileMenu) {
    profileToggleButton.addEventListener("click", (event) => {
        event.stopPropagation();
        profileMenu.classList.toggle("hidden");
    });
}

passwordOpenButtons.forEach((button) => {
    button.addEventListener("click", openDoctorPasswordModal);
});

profileOpenButtons.forEach((button) => {
    button.addEventListener("click", openDoctorProfileModal);
});

passwordCloseButtons.forEach((button) => {
    button.addEventListener("click", closeDoctorPasswordModal);
});

profileCloseButtons.forEach((button) => {
    button.addEventListener("click", closeDoctorProfileModal);
});

if (patientDrawerOverlay) {
    patientDrawerOverlay.addEventListener("click", closePatientDrawer);
}

if (passwordModal) {
    passwordModal.addEventListener("click", (event) => {
        if (event.target === passwordModal) {
            closeDoctorPasswordModal();
        }
    });
}

if (profileModal) {
    profileModal.addEventListener("click", (event) => {
        if (event.target === profileModal) {
            closeDoctorProfileModal();
        }
    });
}

document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
        closePatientDrawer();
        closeDoctorProfileMenu();
        closeDoctorPasswordModal();
        closeDoctorProfileModal();
    }
});

window.addEventListener("pageshow", () => {
    window.requestAnimationFrame(() => {
        hidePageLoader();
    });
});

window.addEventListener("click", (event) => {
    if (
        profileMenu &&
        profileToggleButton &&
        !profileMenu.classList.contains("hidden")
    ) {
        const clickedInsideMenu = profileMenu.contains(event.target);
        const clickedToggle = profileToggleButton.contains(event.target);

        if (!clickedInsideMenu && !clickedToggle) {
            closeDoctorProfileMenu();
        }
    }
});

hidePageLoader();

updatePrescriptionItemTitles();
filterAppointments();

window.addEventListener("beforeunload", () => {
    showPageLoader();
    if (appShell) {
        appShell.style.visibility = "hidden";
    }
});

window.addEventListener("load", () => {
    if (appShell) {
        appShell.style.visibility = "visible";
    }
    hidePageLoader();
});
