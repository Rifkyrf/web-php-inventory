// PRO-INV JavaScript Functions
// Enhanced functionality untuk sistem inventory

// Utility functions
const $ = (id) => document.getElementById(id);
const $$ = (selector) => document.querySelectorAll(selector);

// Sidebar Management
class SidebarManager {
    constructor() {
        this.sidebar = $('sidebar');
        this.init();
    }
    
    init() {
        // Auto-close sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && 
                !this.sidebar.contains(e.target) && 
                !e.target.closest('button[onclick="toggleMenu()"]')) {
                this.close();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                this.sidebar.classList.remove('sidebar-closed');
            }
        });
    }
    
    toggle() {
        this.sidebar.classList.toggle('sidebar-closed');
    }
    
    close() {
        this.sidebar.classList.add('sidebar-closed');
    }
}

// Modal Management
class ModalManager {
    constructor() {
        this.overlay = $('modalOverlay');
        this.init();
    }
    
    init() {
        // Close modal when clicking overlay
        this.overlay.addEventListener('click', (e) => {
            if (e.target === this.overlay) {
                this.close();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.overlay.classList.contains('hidden')) {
                this.close();
            }
        });
    }
    
    open(modalId) {
        this.overlay.classList.remove('hidden');
        $$('.modal-box').forEach(box => box.classList.add('hidden'));
        $(modalId).classList.remove('hidden');
        
        // Focus first input
        const firstInput = $(modalId).querySelector('input:not([type="hidden"])');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
    }
    
    close() {
        this.overlay.classList.add('hidden');
    }
}

// Form Validation
class FormValidator {
    static validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    static validatePassword(password, minLength = 6) {
        return password.length >= minLength;
    }
    
    static showError(message) {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-[300] transform translate-x-full transition-transform';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => document.body.removeChild(toast), 300);
        }, 3000);
    }
    
    static showSuccess(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg z-[300] transform translate-x-full transition-transform';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => document.body.removeChild(toast), 300);
        }, 3000);
    }
}

// Export Functions
class ExportManager {
    static toExcel(tableId, filename = 'export') {
        const table = $(tableId);
        if (!table) return;
        
        const tableHTML = table.outerHTML.replace(/ /g, '%20');
        const downloadLink = document.createElement('a');
        document.body.appendChild(downloadLink);
        downloadLink.href = 'data:application/vnd.ms-excel,' + tableHTML;
        downloadLink.download = filename + '.xls';
        downloadLink.click();
        document.body.removeChild(downloadLink);
        
        FormValidator.showSuccess('File Excel berhasil diunduh!');
    }
    
    static toPDF() {
        window.print();
    }
}

// Search and Filter
class SearchManager {
    static filterTable(searchInput, tableId) {
        const filter = searchInput.value.toLowerCase();
        const table = $(tableId);
        const rows = table.getElementsByTagName('tr');
        
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;
            
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toLowerCase().includes(filter)) {
                    found = true;
                    break;
                }
            }
            
            row.style.display = found ? '' : 'none';
        }
    }
}

// Initialize managers
let sidebarManager, modalManager;

document.addEventListener('DOMContentLoaded', function() {
    sidebarManager = new SidebarManager();
    modalManager = new ModalManager();
    
    // Add loading states to forms
    $$('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                }, 2000);
            }
        });
    });
    
    // Add hover effects to cards
    $$('.bg-white').forEach(card => {
        card.classList.add('card-hover');
    });
    
    // Add bounce effect to icons
    $$('svg').forEach(icon => {
        icon.classList.add('icon-bounce');
    });
});

// Global functions for backward compatibility
function toggleMenu() {
    sidebarManager.toggle();
}

function openModal(modalId) {
    modalManager.open(modalId);
}

function closeModal() {
    modalManager.close();
}

function exportTableToExcel(tableId, filename) {
    ExportManager.toExcel(tableId, filename);
}

// Enhanced transaction modal
function openTrxModal(id, nama, jenis) {
    $('trx_id').value = id;
    $('trx_jenis').value = jenis;
    $('trxTitle').innerText = `Konfirmasi ${jenis}`;
    $('trxSub').innerText = nama;
    
    const btn = $('trxBtn');
    btn.innerText = `Update ${jenis}`;
    btn.className = `w-full py-6 text-white rounded-[2rem] font-black shadow-2xl uppercase tracking-[0.2em] active:scale-95 transition ${
        jenis == 'masuk' ? 'bg-emerald-500 shadow-emerald-500/30' : 'bg-orange-500 shadow-orange-500/30'
    }`;
    
    openModal('modalTrx');
}

// Enhanced user modal
function openUserModal(id = '', email = '') {
    $('user_id').value = id;
    $('user_email').value = email;
    $('user_password').value = '';
    
    const hint = $('passwordHint');
    const passwordField = $('user_password');
    
    if (id) {
        hint.style.display = 'inline';
        passwordField.required = false;
        passwordField.placeholder = '••••••••';
    } else {
        hint.style.display = 'none';
        passwordField.required = true;
        passwordField.placeholder = 'Masukkan password';
    }
    
    openModal('modalUser');
}

// Real-time form validation
document.addEventListener('DOMContentLoaded', function() {
    const emailInputs = $$('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value && !FormValidator.validateEmail(this.value)) {
                this.classList.add('border-red-500');
                FormValidator.showError('Format email tidak valid');
            } else {
                this.classList.remove('border-red-500');
            }
        });
    });
    
    const passwordInputs = $$('input[type="password"]');
    passwordInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.required && this.value && !FormValidator.validatePassword(this.value)) {
                this.classList.add('border-red-500');
            } else {
                this.classList.remove('border-red-500');
            }
        });
    });
});