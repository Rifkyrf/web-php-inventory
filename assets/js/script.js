/**
 * PRO-INV JavaScript Functions
 * Professional Inventory Management System
 * 
 * @author PRO-INV Team
 * @version 1.0
 */

// ==================== GLOBAL VARIABLES ====================
const overlay = document.getElementById('modalOverlay');

// Test function
function testProfileDropdown() {
    console.log('Testing profile dropdown...');
    const dropdown = document.getElementById('profileDropdown');
    console.log('Dropdown found:', !!dropdown);
    if (dropdown) {
        dropdown.classList.toggle('hidden');
        console.log('Dropdown toggled');
    }
}

// Make function available globally for testing
window.testProfileDropdown = testProfileDropdown;
window.toggleProfileDropdown = toggleProfileDropdown;

// ==================== SIDEBAR MANAGEMENT ====================
function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('sidebar-closed');
}

// ==================== MODAL MANAGEMENT ====================
function closeModal() { 
    overlay.classList.add('hidden'); 
}

function openModal(id) { 
    overlay.classList.remove('hidden'); 
    document.querySelectorAll('.modal-box').forEach(b => b.classList.add('hidden'));
    document.getElementById(id).classList.remove('hidden');
}

// ==================== TRANSACTION MODAL ====================
function openTrxModal(id, nama, jenis) {
    // Set form values
    document.getElementById('trx_id').value = id;
    document.getElementById('trx_jenis').value = jenis;
    document.getElementById('trxTitle').innerText = `Konfirmasi ${jenis}`;
    document.getElementById('trxSub').innerText = nama;
    
    // Configure button
    const btn = document.getElementById('trxBtn');
    btn.innerText = `Update ${jenis}`;
    btn.className = `w-full py-6 text-white rounded-[2rem] font-black uppercase tracking-[0.2em] active:scale-95 transition ${
        jenis == 'masuk' ? 'bg-emerald-500' : 'bg-orange-500'
    }`;
    
    openModal('modalTrx');
}

// ==================== USER MODAL ====================
function openUserModal(id = '', email = '') {
    // Reset form
    document.getElementById('user_id').value = id;
    document.getElementById('user_email').value = email;
    document.getElementById('user_password').value = '';
    
    const hint = document.getElementById('passwordHint');
    const passwordField = document.getElementById('user_password');
    
    // Reset password field type
    passwordField.type = 'password';
    updateEyeIcon(false);
    
    if (id) {
        // Edit mode - ambil password dari database
        hint.style.display = 'inline';
        passwordField.required = false;
        
        // Fetch password dari database
        fetch(`index.php?action=get_user&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.password && data.password !== 'exists') {
                    // Tampilkan password asli dari database
                    passwordField.value = data.password;
                    passwordField.placeholder = 'Password saat ini';
                } else {
                    passwordField.placeholder = 'Masukkan password baru';
                }
            })
            .catch(() => {
                passwordField.placeholder = 'Masukkan password baru';
            });
    } else {
        // Create mode
        hint.style.display = 'none';
        passwordField.required = true;
        passwordField.placeholder = 'Masukkan password';
    }
    
    openModal('modalUser');
}

// ==================== PASSWORD VISIBILITY ====================
function togglePassword() {
    const passwordField = document.getElementById('user_password');
    const isPassword = passwordField.type === 'password';
    
    // Toggle input type
    passwordField.type = isPassword ? 'text' : 'password';
    
    // Update icon
    updateEyeIcon(isPassword);
}

function updateEyeIcon(showPassword) {
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (showPassword) {
        // Show eye-off icon
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        // Show eye icon
        eyeIcon.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
    }
}

// ==================== PROFILE DROPDOWN ====================
function toggleProfileDropdown() {
    console.log('toggleProfileDropdown called');
    const dropdown = document.getElementById('profileDropdown');
    console.log('Dropdown element:', dropdown);
    
    if (dropdown) {
        const isHidden = dropdown.classList.contains('hidden');
        console.log('Is hidden:', isHidden);
        
        if (isHidden) {
            dropdown.classList.remove('hidden');
            console.log('Dropdown shown');
        } else {
            dropdown.classList.add('hidden');
            console.log('Dropdown hidden');
        }
    } else {
        console.error('Profile dropdown element not found!');
    }
}

function closeProfileDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    if (dropdown) {
        dropdown.classList.add('hidden');
    }
}

function openProfileModal(type) {
    const modal = document.getElementById('profileModalOverlay');
    const title = document.getElementById('profileModalTitle');
    const action = document.getElementById('profile_action');
    const emailField = document.getElementById('emailField');
    const passwordFields = document.getElementById('passwordFields');
    
    if (!modal || !title || !action || !emailField || !passwordFields) {
        console.error('Profile modal elements not found');
        return;
    }
    
    // Reset fields
    emailField.classList.add('hidden');
    passwordFields.classList.add('hidden');
    
    // Reset form
    const form = modal.querySelector('form');
    if (form) form.reset();
    
    if (type === 'email') {
        title.textContent = 'Edit Email';
        action.value = 'update_email';
        emailField.classList.remove('hidden');
        const emailInput = document.getElementById('new_email');
        if (emailInput) {
            emailInput.required = true;
            emailInput.focus();
        }
    } else if (type === 'password') {
        title.textContent = 'Edit Password';
        action.value = 'update_password';
        passwordFields.classList.remove('hidden');
        const oldPasswordInput = document.getElementById('old_password');
        const newPasswordInput = document.getElementById('new_password');
        if (oldPasswordInput && newPasswordInput) {
            oldPasswordInput.required = true;
            newPasswordInput.required = true;
            oldPasswordInput.focus();
        }
    }
    
    modal.classList.remove('hidden');
    closeProfileDropdown();
}

function closeProfileModal() {
    const modal = document.getElementById('profileModalOverlay');
    if (modal) {
        modal.classList.add('hidden');
        
        // Reset form
        const form = modal.querySelector('form');
        if (form) form.reset();
        
        // Reset required attributes
        const inputs = modal.querySelectorAll('input');
        inputs.forEach(input => {
            input.required = false;
        });
    }
}

function togglePasswordField(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;
    
    const button = field.parentElement.querySelector('button i');
    if (!button) return;
    
    if (field.type === 'password') {
        field.type = 'text';
        button.className = 'bi bi-eye-slash text-lg';
    } else {
        field.type = 'password';
        button.className = 'bi bi-eye text-lg';
    }
}

// ==================== EXPORT FUNCTIONS ====================
function exportTableToExcel(tableID, filename = '') {
    const table = document.getElementById(tableID);
    if (!table) return;
    
    const tableHTML = table.outerHTML.replace(/ /g, '%20');
    const downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    downloadLink.href = 'data:application/vnd.ms-excel,' + tableHTML;
    downloadLink.download = filename + '.xls';
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// ==================== EVENT LISTENERS ====================
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar management
    window.addEventListener('click', (e) => {
        const sidebar = document.getElementById('sidebar');
        const isMobile = window.innerWidth < 768;
        const clickedSidebar = sidebar && sidebar.contains(e.target);
        const clickedToggle = e.target.closest('button[onclick="toggleMenu()"]');
        
        // Close sidebar on mobile when clicking outside
        if (isMobile && sidebar && !clickedSidebar && !clickedToggle) {
            sidebar.classList.add('sidebar-closed');
        }
        
        // Close modal when clicking overlay
        if (overlay && e.target === overlay) {
            closeModal();
        }
        
        // Close profile modal when clicking overlay
        const profileModal = document.getElementById('profileModalOverlay');
        if (profileModal && e.target === profileModal) {
            closeProfileModal();
        }
        
        // Close profile dropdown when clicking outside
        const profileDropdown = document.getElementById('profileDropdown');
        const profileContainer = document.getElementById('profileContainer');
        const profileButton = document.getElementById('profileButton');
        
        if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
            // Check if click is outside the profile container
            if (profileContainer && !profileContainer.contains(e.target)) {
                closeProfileDropdown();
            }
        }
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        // Close modal with Escape key
        if (e.key === 'Escape') {
            if (overlay && !overlay.classList.contains('hidden')) {
                closeModal();
            }
            
            const profileModal = document.getElementById('profileModalOverlay');
            if (profileModal && !profileModal.classList.contains('hidden')) {
                closeProfileModal();
            }
            
            const profileDropdown = document.getElementById('profileDropdown');
            if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
                closeProfileDropdown();
            }
        }
    });
});