import './bootstrap';
import { HSOverlay, HSStaticMethods } from 'preline';

// Manually expose Preline components to the global window object
// This is required for programmatic control (e.g. HSOverlay.open()) in Vite environments
window.HSOverlay = HSOverlay;
window.HSStaticMethods = HSStaticMethods;

// Preline initialization on page load
document.addEventListener('DOMContentLoaded', () => {
    if (window.HSStaticMethods) {
        window.HSStaticMethods.autoInit();
    }
    console.log('Preline initialization complete');
});

// Global CRUD Handler
window.CrudHandler = {
    toast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const template = document.getElementById('toast-template');
        if (!container || !template) return;

        const clone = template.content.cloneNode(true);
        const toast = clone.querySelector('[role="alert"]');
        const messageEl = clone.querySelector('#toast-message');
        const iconContainer = clone.querySelector('#toast-icon-container');

        messageEl.textContent = message;

        const icons = {
            success: `<svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>`,
            error: `<svg class="shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`
        };

        iconContainer.innerHTML = icons[type] || icons.success;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s ease-out';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    },

    openModal(modalId) {
        if (!window.HSOverlay) return;
        const modalEl = document.getElementById(modalId);
        if (modalEl) {
            window.HSOverlay.open(modalEl);
        } else {
            console.error(`Modal with ID ${modalId} not found`);
        }
    },

    cleanupBackdrops() {
        // Find and remove all Preline backdrops to prevent "stuck" dark screens
        const backdrops = document.querySelectorAll('.hs-overlay-backdrop');
        backdrops.forEach(b => b.remove());
        
        // Remove 'overflow: hidden' and pointer-events from body if modal didn't clean up
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        document.body.classList.remove('overflow-y-hidden'); // Preline class
    },

    async submitForm(formId, modalId, tableContainerId) {
        const form = document.getElementById(formId);
        if (!form) return;

        const formData = new FormData(form);
        const url = form.action;
        const methodField = form.querySelector('input[name="_method"]');
        const method = methodField ? methodField.value : form.method;

        // Disable buttons
        const submitBtn = form.closest('.hs-overlay')?.querySelector('button[onclick*="submitForm"]') || form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-white rounded-full" role="status" aria-label="loading"></span> Processing...`;
        }

        try {
            const response = await axios({
                url: url,
                method: method,
                data: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (response.data.success) {
                this.toast(response.data.message);
                
                // 1. Trigger Modal Close FIRST
                if (modalId && window.HSOverlay) {
                    const modalEl = document.getElementById(modalId);
                    if (modalEl) {
                        window.HSOverlay.close(modalEl);
                    }
                }
                
                // 2. Short Delay to allow animation to start, then swap HTML
                setTimeout(() => {
                    if (tableContainerId && response.data.html) {
                        const container = document.getElementById(tableContainerId);
                        if (container) {
                            container.innerHTML = response.data.html;
                            
                            // 3. Force clean backdrops if they got interrupted
                            this.cleanupBackdrops();

                            // 4. Re-init Components
                            setTimeout(() => {
                                if (window.HSStaticMethods) window.HSStaticMethods.autoInit();
                                if (window.HSOverlay) window.HSOverlay.autoInit();
                            }, 100);
                        }
                    }
                }, 300); // Wait 300ms for Preline close animation

                form.reset();
            }
        } catch (error) {
            console.error(error);
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                const firstError = Object.values(errors)[0][0];
                this.toast(firstError, 'error');
            } else {
                this.toast('An unexpected error occurred.', 'error');
            }
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = modalId?.includes('edit') ? 'Update' : 'Simpan';
            }
        }
    },

    // Step 1: Open the Preline confirmation modal and bind the action
    confirmDelete(url, tableContainerId) {
        const confirmBtn = document.getElementById('confirm-delete-btn');
        if (!confirmBtn) {
            console.error('Confirm delete button not found');
            return;
        }

        // Reset and set the click handler for the confirm button
        confirmBtn.onclick = () => this.executeDelete(url, tableContainerId);

        // Open the global confirmation modal
        if (window.HSOverlay) {
            const modalEl = document.getElementById('hs-delete-confirmation-modal');
            if (modalEl) {
                window.HSOverlay.open(modalEl);
            } else {
                console.error('Delete confirmation modal not found in DOM');
            }
        } else {
            console.error('HSOverlay is not defined on window');
        }
    },

    // Step 2: Execute the actual deletion via AJAX
    executeDelete(url, tableContainerId) {
        const confirmBtn = document.getElementById('confirm-delete-btn');
        if (confirmBtn) {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = `<span class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-white rounded-full" role="status" aria-label="loading"></span> Deleting...`;
        }

        axios.delete(url)
            .then(response => {
                if (response.data.success) {
                    this.toast(response.data.message);
                    
                    // Close confirmation modal
                    if (window.HSOverlay) {
                        const modalEl = document.getElementById('hs-delete-confirmation-modal');
                        if (modalEl) window.HSOverlay.close(modalEl);
                    }

                    // Refresh table after a short delay
                    setTimeout(() => {
                        if (tableContainerId && response.data.html) {
                            const container = document.getElementById(tableContainerId);
                            if (container) {
                                container.innerHTML = response.data.html;
                                this.cleanupBackdrops();
                                setTimeout(() => {
                                    if (window.HSStaticMethods) window.HSStaticMethods.autoInit();
                                    if (window.HSOverlay) window.HSOverlay.autoInit();
                                }, 100);
                            }
                        }
                    }, 300);
                }
            })
            .catch((err) => {
                console.error(err);
                this.toast('Delete failed.', 'error');
            })
            .finally(() => {
                if (confirmBtn) {
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = 'Ya, Saya Yakin';
                }
            });
    },

    // --- Penjadwalan Helpers ---
    openEditShiftModal(id, nama, masuk, keluar, hari) {
        const form = document.getElementById('edit-shift-form');
        if (!form) return;

        form.action = `/penjadwalan/shift/${id}`;
        document.getElementById('edit-shift-nama').value = nama;
        document.getElementById('edit-shift-masuk').value = masuk;
        document.getElementById('edit-shift-keluar').value = keluar;
        document.getElementById('edit-shift-hari').value = hari;

        this.openModal('hs-edit-shift-modal');
    },

    openEditJadwalModal(id, shiftId, dokterId, ruangId) {
        const form = document.getElementById('edit-jadwal-form');
        if (!form) return;

        form.action = `/penjadwalan/jadwal/${id}`;
        document.getElementById('edit-jadwal-shift').value = shiftId;
        document.getElementById('edit-jadwal-dokter').value = dokterId;
        document.getElementById('edit-jadwal-ruang').value = ruangId;

        this.openModal('hs-edit-jadwal-modal');
    },

    openEditRuangModal(id, nama, poliId) {
        const form = document.getElementById('edit-ruang-form');
        if (!form) return;

        form.action = `/penjadwalan/ruang/${id}`;
        document.getElementById('edit-ruang-nama').value = nama;
        document.getElementById('edit-ruang-poli').value = poliId;

        this.openModal('hs-edit-ruang-modal');
    },

    // --- Obat Helpers ---
    openEditObatModal(id, nama, kemasan, harga) {
        const form = document.getElementById('edit-obat-form');
        if (!form) return;

        form.action = `/obat/list/${id}`;
        document.getElementById('edit-obat-nama').value = nama;
        document.getElementById('edit-obat-kemasan').value = kemasan;
        document.getElementById('edit-obat-harga').value = harga;

        this.openModal('hs-edit-obat-modal');
    },

    openUpdateStokModal(id, nama, stok) {
        const form = document.getElementById('update-stok-form');
        if (!form) return;

        form.action = `/obat/list/${id}`;
        document.getElementById('stok-obat-nama-display').textContent = nama;
        document.getElementById('edit-obat-stok-value').value = stok;

        this.openModal('hs-update-stok-modal');
    },

    openEditUserModal(id, username, email, role) {
        const form = document.getElementById('edit-user-form');
        if (!form) return;

        form.action = `/admin/users/${id}`;
        document.getElementById('edit-user-username').value = username;
        document.getElementById('edit-user-email').value = email;
        document.getElementById('edit-user-role').value = role;

        this.openModal('hs-edit-user-modal');
    },

    async refreshTable(url, containerId, params = {}) {
        const queryParams = new URLSearchParams(params).toString();
        const fullUrl = queryParams ? `${url}?${queryParams}` : url;

        try {
            const response = await axios.get(fullUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (response.data.success && response.data.html) {
                const container = document.getElementById(containerId);
                if (container) {
                    container.innerHTML = response.data.html;
                    
                    // Re-init Preline components
                    if (window.HSStaticMethods) window.HSStaticMethods.autoInit();
                }
            }
        } catch (error) {
            console.error('Table refresh failed:', error);
        }
    }
};

console.log('app.js Refined - Global UX Handler Ready with Explicit Preline Exports');