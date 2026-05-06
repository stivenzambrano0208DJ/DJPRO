/**
 * DJPRO - Global JavaScript
 * Handcrafted interactive elements
 */

document.addEventListener('DOMContentLoaded', () => {
    console.log('DJPRO Core Initialized 🎧');
    
    // Initialize UI Components
    initToasts();
    initScrollEffects();
});

/**
 * Toast Notification System
 * Usage: djpro.toast('Success Message', 'success')
 */
const djpro = {
    toast: (message, type = 'info') => {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast-item ${type} transform translate-x-full transition-all duration-500 bg-djpro-surface border-l-4 p-4 rounded-xl shadow-2xl flex items-center gap-3 mb-3`;
        
        let icon = 'bi-info-circle';
        let border = 'border-blue-500';
        if (type === 'success') { icon = 'bi-check-circle-fill'; border = 'border-green-500'; }
        if (type === 'error') { icon = 'bi-exclamation-triangle-fill'; border = 'border-red-500'; }
        if (type === 'warning') { icon = 'bi-exclamation-circle-fill'; border = 'border-djpro-accent'; }

        toast.innerHTML = `
            <i class="bi ${icon} text-xl ${type === 'success' ? 'text-green-500' : type === 'error' ? 'text-red-500' : 'text-djpro-accent'}"></i>
            <span class="text-sm font-bold text-white uppercase tracking-widest">${message}</span>
        `;

        container.appendChild(toast);

        // Animate In
        setTimeout(() => toast.classList.remove('translate-x-full'), 100);

        // Remove after 5 seconds
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-[-20px]');
            setTimeout(() => toast.remove(), 500);
        }, 5000);
    }
};

function initToasts() {
    // Create container if not exists
    if (!document.getElementById('toast-container')) {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed bottom-8 right-8 z-[9999] flex flex-col items-end pointer-events-none';
        document.body.appendChild(container);
    }
}

function initScrollEffects() {
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal-active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
}

// Global UI interactions
window.toggleMenu = () => {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('translate-x-full');
};
