import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// DOM Elements
const DOM = {
    init() {
        this.navbar = document.querySelector('.navbar');
        this.forms = document.querySelectorAll('form');
        this.modals = document.querySelectorAll('.modal');
        this.alerts = document.querySelectorAll('.alert');
    }
};

// Event Handlers
const EventHandlers = {
    initializeFormValidation(form) {
        form.addEventListener('submit', (e) => {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    },

    initializeModals(modal) {
        const closeButtons = modal.querySelectorAll('[data-dismiss="modal"]');
        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.classList.remove('show');
            });
        });
    },

    initializeAlerts(alert) {
        const closeButton = alert.querySelector('.alert-close');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                alert.remove();
            });
        }

        // Auto-dismiss after 5 seconds if it's a success message
        if (alert.classList.contains('alert-success')) {
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    }
};

// Utility Functions
const Utils = {
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    formatDate(date) {
        return new Date(date).toLocaleDateString();
    },

    formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    }
};

// Initialize Application
document.addEventListener('DOMContentLoaded', () => {
    // Initialize DOM elements
    DOM.init();

    // Initialize forms
    DOM.forms.forEach(form => {
        EventHandlers.initializeFormValidation(form);
    });

    // Initialize modals
    DOM.modals.forEach(modal => {
        EventHandlers.initializeModals(modal);
    });

    // Initialize alerts
    DOM.alerts.forEach(alert => {
        EventHandlers.initializeAlerts(alert);
    });

    // Add scroll behavior for navbar
    window.addEventListener('scroll', Utils.debounce(() => {
        if (window.scrollY > 50) {
            DOM.navbar?.classList.add('navbar-scrolled');
        } else {
            DOM.navbar?.classList.remove('navbar-scrolled');
        }
    }, 100));
});
