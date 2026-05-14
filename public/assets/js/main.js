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
    toast: (message, type = 'info', title = '') => {
        const container = document.getElementById('toast-container');
        if (!container) return;

        let icon = 'bi-info-circle';
        let border = 'border-blue-500';
        let iconColor = 'text-blue-500';
        let shadow = 'shadow-blue-500/10';

        if (type === 'success') { 
            icon = 'bi-check-circle-fill'; 
            border = 'border-green-500';
            iconColor = 'text-green-500';
            shadow = 'shadow-green-500/20';
        } else if (type === 'error') { 
            icon = 'bi-exclamation-triangle-fill'; 
            border = 'border-red-500';
            iconColor = 'text-red-500';
            shadow = 'shadow-red-500/20';
        } else if (type === 'warning') { 
            icon = 'bi-chat-right-text-fill'; 
            border = 'border-djpro-accent';
            iconColor = 'text-djpro-accent';
            shadow = 'shadow-orange-500/20';
        }

        const toast = document.createElement('div');
        toast.className = `toast-item ${type} transform translate-x-full opacity-0 transition-all duration-500 bg-djpro-surface/90 backdrop-blur-md border-l-4 ${border} p-4 rounded-2xl shadow-2xl ${shadow} flex items-center gap-4 mb-4`;
        
        const titleHtml = title ? `<h4 class="font-bold text-white text-sm leading-none mb-1">${title}</h4>` : '';
        
        toast.innerHTML = `
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/5">
                <i class="bi ${icon} text-xl ${iconColor}"></i>
            </div>
            <div class="flex-1">
                ${titleHtml}
                <p class="text-xs font-medium text-djpro-text/90 leading-tight">${message}</p>
            </div>
        `;

        container.appendChild(toast);

        // Animate In
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        }, 100);

        // Remove after 3 seconds (User requested)
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-[-20px]');
            setTimeout(() => toast.remove(), 500);
        }, 3000);
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
